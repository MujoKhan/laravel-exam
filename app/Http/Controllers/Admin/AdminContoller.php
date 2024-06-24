<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Admin;
use App\Models\StdClass;
use App\Models\Teacher;
use App\Models\ClassAndTeacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminContoller extends Controller
{
    public function check(Request $request)
    {
        $valid = $request->validate([
            
            'email'=> 'required|email|exists:admins,email',
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ],[
            'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',
            'email.exists'=>'Email is not exists',
        ]);

        $admin = Admin::where('email',$request->email)->where('permission','Yes')->get();
        foreach($admin as $data)
        {
            session()->put('count',Hash::check($request['password'],$data->password));
        }
        
        

        if(($admin->count() == 1))
        {
           if((session()->get('count') == 1))
           {
                if (Auth::guard('admin')->attempt($request->only('email','password')))
                {
                    return redirect()->route('admin.home');
                }
           }
           else
           {
            return redirect()->back()->with('status','Wrong password');
           }           
        }
        else
        {
            return redirect()->back()->with('status','Dear admin, Super admin not allow you');
        }    
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function fetch()
    {
        $admin = Admin::where('permission','Yes')->get();
        $teacher = Teacher::where('permission','Yes')->get();
        $student = Student::where('permission','Yes')->get();
        $class = StdCLass::all();
        $adminCount = $admin->count();
        $teacherCount = $teacher->count();
        $studentCount = $student->count();
        $classCount = $class->count();

        return response()->json([
            'adminCount'=>$adminCount,
            'teacherCount'=>$teacherCount,
            'studentCount'=>$studentCount,
            'classCount'=>$classCount,
        ]);
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

       $admin = Admin::where('email', Auth::guard('admin')->user()->email)->get();

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
        
        $adminUpdate = Admin::find(Auth::guard('admin')->user()->id);

        $adminUpdate->name = $request->name;
        $adminUpdate->password = session()->get('password');

        $update = $adminUpdate->update();
         if($update)
            {
                return redirect()->back()->with('status', 'Admin profile has been updated');
            }
            else
            {
                return redirect()->back()->with('status', 'Admin profile  not update');
            }
   }

   public function index($v)
   {
       if($v == "add teacher")
       {
           $teacher = Teacher::where('permission','Yes')->get();
            session()->put('addteacher', 1);
            session()->forget('trashteacher', 1);
            session()->forget('allowteacher', 1);
            return view('admin.show',compact('teacher'));
        }
        elseif($v == "trash teacher")
        {
            $teacher = Teacher::onlyTrashed()->get();
            session()->forget('addteacher', 1);
            session()->put('trashteacher', 1);
            session()->forget('allowteacher', 1);
            return view('admin.show',compact('teacher'));
            
        }
        elseif($v == "permission teacher")
        {
            $teacher = Teacher::withTrashed()->get();
            session()->forget('addteacher', 1);
            session()->forget('trashteacher', 1);
            session()->put('allowteacher', 1);
            return view('admin.show',compact('teacher'));
            
       }
   }

   public function addTeacher(Request $request)
   {
        $valid = $request->validate([
            'name' => ['required','regex:/^[a-zA-Z ]+$/'],    
            'email'=> 'required|email|unique:teachers,email',
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'phone'=>'required|digits:10',
            'dob'=>'required|date',
            'gender'=>'required',
        ],[
            'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',
            'email.unique'=>'Email already exists',
            'name.regex'=>'Name should be only string',
        ]);  

        $teacher = new Teacher;
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->dob = $request->dob;
        $teacher->gender = $request->gender;
        $teacher->password = Hash::make($request->password);
        $save = $teacher->save();
        if($save)
        {
            return redirect()->back()->with('status','New teacher has been added');
        }
        else
        {
            return redirect()->back()->with('status','New teacher not add');
        }
   }
   public function updateTeacher(Request $request)
   {
        if($request->password == "")
        {
            $valid = $request->validate([
                'name' => ['required','regex:/^[a-zA-Z ]+$/'],    
                'phone'=>'required|digits:10',
                'dob'=>'required|date',
                'gender'=>'required',
            ],[
                'name.regex'=>'Name should be only string',
            ]);  
        }
        else
        {
            $valid = $request->validate([
                'name' => ['required','regex:/^[a-zA-Z ]+$/'],    
                'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'phone'=>'required|digits:10',
                'dob'=>'required|date',
                'gender'=>'required',
            ],[
                'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',
                'name.regex'=>'Name should be only string',
            ]);  
        }

        $teacher = Teacher::where('id',$request->teacher_id)->get();

        foreach($teacher as $data)
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

        $teacher1 = Teacher::find($request->teacher_id);
        $teacher1->name = $request->name;
        $teacher1->phone = $request->phone;
        $teacher1->dob = $request->dob;
        $teacher1->gender = $request->gender;
        $teacher1->password =  session()->get('password');
        $update = $teacher1->update();
        if($update)
        {
            return redirect()->back()->with('status','Teacher has been updated');
        }
        else
        {
            return redirect()->back()->with('status','Teacher not update');
        }
   }

   public function allow($id, $v)
   {
       $teacher = Teacher::find($id);
       if($v == "allow teacher")
       {
            $teacher->permission = "Yes";
            $update = $teacher->update();
            if($update)
            {
                return redirect()->back()->with('status','Teacher has been allowed');
            }
            else
            {
                return redirect()->back()->with('status','Teacher not allow');

            }
       }
       elseif($v == "block teacher")
       {
        $teacher->permission = "No";
        $update = $teacher->update();
        if($update)
        {
            return redirect()->back()->with('status','Teacher has been blocked');
        }
        else
        {
            return redirect()->back()->with('status','Teacher not block');

        }
       }
   }

   public function trash($id, $v)
   {
       if($v == "trash teacher")
       {
           $teacher = Teacher::find($id)->delete();
           if($teacher)
           {
            return redirect()->back()->with('status','Teacher has been trashed');
            }
            else
            {
                return redirect()->back()->with('status','Teacher not trash');
            }
        }

        elseif($v == "restore teacher")
        {
           $teacher = Teacher::onlyTrashed()->find($id)->restore();
           if($teacher)
           {
            return redirect()->back()->with('status','Teacher has been restored');
            }
            else
            {
                return redirect()->back()->with('status','Teacher not restore');
            }
        }

        elseif($v == "delete teacher")
        {
           $teacher = Teacher::onlyTrashed()->find($id)->forceDelete();
           if($teacher)
           {
            return redirect()->back()->with('status','Teacher has been deleted');
            }
            else
            {
                return redirect()->back()->with('status','Teacher not delete');
            }
        }
        elseif($v == "trash class")
        {
           $teacher = StdClass::find($id)->delete();
           if($teacher)
           {
            return redirect()->back()->with('status','Class has been trahsed');
            }
            else
            {
                return redirect()->back()->with('status','Class not trash');
            }
        }
        elseif($v == "restore class")
        {
           $teacher = StdClass::onlyTrashed()->find($id)->restore();
           if($teacher)
           {
            return redirect()->back()->with('status','Class has been restored');
            }
            else
            {
                return redirect()->back()->with('status','Class not restore');
            }
        }
        elseif($v == "delete class")
        {
           $teacher = StdClass::onlyTrashed()->find($id)->forceDelete();
           if($teacher)
           {
            return redirect()->back()->with('status','Class has been deleted');
            }
            else
            {
                return redirect()->back()->with('status','Class not delete');
            }
        }
   }

   public function classManage($v)
   {
       if($v == "class manage")
       {
           $class = StdClass::all();
           session()->put('class',1);
           session()->forget('trash',1);
           return view('admin.class',compact('class'));   
       }
       elseif($v == "class trash")
       {
            $class = StdClass::onlyTrashed()->get();
            session()->forget('class',1);
            session()->put('trash',1);
            return view('admin.class',compact('class'));              
       }
   }

   public function classAdd(Request $request)
   {
       $valid = $request->validate([
           'class' => 'required',
       ]);

       $classMtach = StdClass::where('class_name',$request->class)->get();
       if($classMtach->count() == 0)
       {

            $class = new StdClass;
            $class->class_name = $request->class;
            $save = $class->save();
            if($save)
            {
                return redirect()->back()->with('status','New class has been added');
                }
                else
                {
                return redirect()->back()->with('status','New class not add');
            }
       }
       else {
        return redirect()->back()->with('status','This class already exists');
       }    
   }


   public function classUpdate(Request $request)
   {
       $valid = $request->validate([
           'class' => 'required',
       ]);

       $class =  StdClass::find($request->class_id);
       $class->class_name = $request->class;
       $update = $class->update();
       if($update)
       {
           return redirect()->back()->with('status','Class has been updated');
        }
        else
        {
           return redirect()->back()->with('status','Class not update');
       }
   }

   public function assign()
   {
        $class = StdClass::all();
        $teacher = Teacher::where('permission','Yes')->get();
        $clasTeacher = ClassAndTeacher::all();
        return view('admin.class-teacher',compact('teacher','class','clasTeacher'));
   }

   public function classAssign(Request $request)
   {

       $clasTeacher = ClassAndTeacher::where('class_id',$request->class_id)->where('teacher_id',$request->teacher)->get();
       if($clasTeacher->count() == 0)
       {
            $clasTeacherInsert = new ClassAndTeacher;
            $clasTeacherInsert->class_id = $request->class_id;
            $clasTeacherInsert->teacher_id = $request->teacher;
            $save = $clasTeacherInsert->save();
            if($save)  
            {
                return redirect()->back()->with('status','Teacher class has been assigned');
            }   
            else
            {
                return redirect()->back()->with('status','Teacher class not assign');
            }   
       }
       else
       {
            $clasTeacherUpdate = ClassAndTeacher::where('class_id',$request->class_id)
                                ->upate(['teacher_id' => $request->teacher]);
            if($clasTeacherUpdate)  
            {
                return redirect()->back()->with('status','Teacher class has been assigned');
            }   
            else
            {
                return redirect()->back()->with('status','Update! Teacher class not assign');
            }               
       }
   }
   
}
