<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Super;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperController extends Controller
{
    public function check(Request $request)
    {
        $valid = $request->validate([
            
            'email'=> 'required|email|exists:supers,email',
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ],[
            'password.regex'=>'The Password Must Be 1 Capital, 1 Small and 1 Digit',
            'email.exists'=>'The Email Is Not Exists',
        ]);

        $super = Super::where('email',$request->email)->get();
        foreach($super as $data)
        {
            session()->put('count',Hash::check($request['password'],$data->password));
        }
        


        if(($super->count() == 1))
        {
           if((session()->get('count') == 1))
           {
                if (Auth::guard('super')->attempt($request->only('email','password')))
                {
                    return redirect()->route('super.home');
                }
           }
           else
           {
            return redirect()->back()->with('status','Wrong password');
           }           
        }
        else
        {
            return redirect()->back()->with('status','Super Admin Not Found');
        }    
    }

    public function logout()
    {
        Auth::guard('super')->logout();
        return redirect()->route('super.login');
    }

    public function profile(Request $request)
   {

    if($request->password == "")
    {

        $valid = $request->validate([
            
            'name' => ['required','regex:/^[a-zA-Z ]+$/'],
        ],[
            
            'name.regex'=>'Name should be only string',       
        ]);
    }
    else
    {
        $valid = $request->validate([
            
            'name' => ['required','regex:/^[a-zA-Z ]+$/'],
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ],[
            
            'name.regex'=>'Name should be only string',  
            'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',    
        ]);
    }    

       $super = Super::where('email', Auth::guard('super')->user()->email)->get();

        foreach($super as $data)
        {
            if($request->password == "")
                {
                    session()->put('password',$data->password);
                }
                else
                {
                    $p = Hash::make($request->password);
                    session()->put('password',$p);
                }
        }
        
        $superUpdate = Super::find(Auth::guard('super')->user()->id);

        $superUpdate->name = $request->name;
        $superUpdate->password = session()->get('password');

        $update = $superUpdate->update();
         if($update)
            {
                return redirect()->back()->with('status', 'Super profile has been updated');
            }
            else
            {
                return redirect()->back()->with('status', 'Super profile  not update');
            }

   }

   public function fetch()
   {
        $super = Super::all();
        $admin = Admin::all();
        $teacher = Teacher::all();
        $student = Student::all();
        $superCount = $super->count();
        $adminCount = $admin->count();
        $teacherCount = $teacher->count();
        $studentCount = $student->count();
       return response()->json([
           'super'=>$superCount,
           'admin'=>$adminCount,
           'teacher'=>$teacherCount,
           'student'=>$studentCount,
       ]);
   }

   public function index($v)
   {
       if($v == "admin")
       {
           $admin = Admin::where('permission','Yes')->get();

           session()->put('admin',1);
           session()->forget('permission',1);
           session()->forget('trash',1);
          
           return view('super.show',compact('admin'));
        }
        elseif($v == "permission")
        {
           $admin = Admin::all();
           session()->forget('admin',1);
           session()->put('permission',1);
           session()->forget('trash',1);
           return view('super.show',compact('admin'));
        }
        elseif($v == "trash")
        {
           $admin = Admin::onlyTrashed()->get();
           session()->forget('admin',1);
           session()->forget('permission',1);
           session()->put('trash',1);
           return view('super.show',compact('admin'));
       }
   }

   public function update(Request $request)
   {
        if($request->password == "")
        {

            $valid = $request->validate([
                
                'name' => ['required','regex:/^[a-zA-Z ]+$/'],
            ],[
                
                'name.regex'=>'Name should be only string',       
            ]);
        }
        else
        {
            $valid = $request->validate([
                
                'name' => ['required','regex:/^[a-zA-Z ]+$/'],
                'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ],[
                
                'name.regex'=>'Name should be only string',  
                'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',     
            ]);
        }    

       $admin = Admin::where('id',$request->admin_id)->get();

        foreach($admin as $data)
        {
            if($request->password == "")
                {
                    session()->put('password',$data->password);
                }
                else
                {
                    $p = Hash::make($request->password);
                    session()->put('password',$p);
                }
        }

        $admin1 = Admin::find($request->admin_id);
        $admin1->name = $request->name;
        $admin1->password = session()->get('password');

        $update = $admin1->update();
        if($update)
        {
            return redirect()->back()->with('status','Admin has been updated');
        }
        else
        {
            return redirect()->back()->with('status','Admin not update');

        }
   }
   public function addAdmin(Request $request)
   {
            $valid = $request->validate([
                
                'name' => ['required','regex:/^[a-zA-Z ]+$/'],
                'email' => 'required|email|unique:admins,email',
                'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ],[
                
                'name.regex'=>'Name should be only string',  
                'password.regex'=>'Password must be 1 capital, 1 small and 1 digit', 
                'email.unique'=>'Email already exists',    
            ]);

        $admin1 = new Admin;
        $admin1->name = $request->name;
        $admin1->email = $request->email;
        $admin1->password = Hash::make($request->password);

        $save = $admin1->save();
        if($save)
        {
            return redirect()->back()->with('status','New Admin has been added');
        }
        else
        {
            return redirect()->back()->with('status','New Admin not add');

        }
   }

   public function trash($id, $v)
   {
       if($v == "trash admin")
       {
           $admin = Admin::find($id)->delete();
           if($admin)
           {
               return redirect()->back()->with('status','Admin has been trashed');
            } 
            else
            {
                return redirect()->back()->with('status','Admin not trash');
           }
       }
   }

   public function restore($id, $v)
   {
       if($v == "restore admin")
       {
           $admin = Admin::onlyTrashed()->find($id)->restore();
           if($admin)
           {
               return redirect()->back()->with('status','Admin has been restored');
            } 
            else
            {
                return redirect()->back()->with('status','Admin not restore');
           }
       }
       elseif($v == "delete admin")
       {
        $admin = Admin::onlyTrashed()->find($id)->forceDelete();
        if($admin)
        {
            return redirect()->back()->with('status','Admin has been deleted');
         } 
         else
         {
             return redirect()->back()->with('status','Admin not delete');
        }
       }    
   }

   public function permission($id, $v)
   {
       if($v == "allow admin")
       {
           $admin = Admin::find($id);
           $admin->permission = "Yes";
           $update = $admin->update();
           if($update)
           {
               return redirect()->back()->with('status','Admin allow');
           }
           else
           {
            return redirect()->back()->with('status','Admin not allow');
           }
       }
       elseif($v == "block admin")
       {
        $admin = Admin::find($id);
        $admin->permission = "No";
        $update = $admin->update();
        if($update)
        {
            return redirect()->back()->with('status','Admin block');
        }
        else
        {
         return redirect()->back()->with('status','Admin not block');
        }
       }
   }
}
