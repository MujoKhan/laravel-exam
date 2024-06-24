<?php

namespace App\Http\Controllers\Teacher;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Student;
use App\Models\StdClass;
use App\Models\ClassAndTeacher;
use App\Models\ExamTime;
use App\Models\ExamQuestion;
use App\Models\StudentAnswer;

class TeacherController extends Controller
{
    public function check(Request $request)
    {
        $vald = $request->validate(
            [
                'email' => 'required|email|exists:teachers,email',
                'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ],[
                'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',
                'email.exists'=>'The email is not exists',
                ]
        );

        $teacher = Teacher::where('email',$request['email'])->where('permission', 'Yes')->get();
        foreach($teacher as $data)
        {
            session()->put('count',Hash::check($request['password'],$data->password));
            session()->put('id',$data->id);
        }

        // dd($credentials);
        if(($teacher->count() == 1))
        {
            if(session()->get('count') == 1)
            {
                if(Auth::guard('teacher')->attempt($request->only('email','password')))
                {
                    $subject = Subject::where('teacher_id', 1)->get();
                    // return view('teacher.home');
                    return redirect()->route('teacher.home');

                }
            }
            else
            {
                return redirect()->route('teacher.login')->with('status','Teacher not found');
            }
        }    
        else
        {
                return redirect()->back()->with('status','Dear Teacher, Admin not allow you');
        }    
        
    }

    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login');
    }

    public function index($v)
    {
        $clas =  ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
        $stdclass = StdClass::all();
        $sub = Subject::where('teacher_id', Auth::guard('teacher')->user()->id)->get();
        if($v == "subject")
        {
            
            session()->put('sub',1);
            session()->forget('trash',1);
            return view('teacher.show',compact('clas','stdclass','sub'));
        }
        elseif($v = "trash")
        {  $clas =  ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
            $stdclass = StdClass::all(); 
            $sub = Subject::where('teacher_id', Auth::guard('teacher')->user()->id)->onlyTrashed()->get();      
            session()->forget('sub',1);
            session()->put('trash',1);
            return view('teacher.show',compact('clas','stdclass','sub'));
        }
    }

    public function exam($v)
    {
        $clas =  ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
        $stdclass = StdClass::all();
        $sub = Subject::where('teacher_id', Auth::guard('teacher')->user()->id)->get();
        $que = ExamQuestion::all();
        $examtime = ExamTime::where('teacher_id',Auth::guard('teacher')->user()->id)->get();

        if($v == "exam add")
        {
            session()->put('add-exam',1);
            session()->forget('trash-exam',1);
            return view('teacher.exam',compact('clas','stdclass','sub','examtime','que'));
        }
        elseif($v == "exam trash")
        {
            $clas =  ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
            $stdclass = StdClass::all();
            $sub = Subject::where('teacher_id', Auth::guard('teacher')->user()->id)->get();
            $que = ExamQuestion::all();
            $examtimeTrash = ExamTime::where('teacher_id',Auth::guard('teacher')->user()->id)->onlyTrashed()->get();

            session()->forget('add-exam',1);
            session()->put('trash-exam',1);
            return view('teacher.exam',compact('clas','stdclass','sub','examtime','que','examtimeTrash'));
        }
    }


    public function addsub(Request $request)
    {
        $stdclass = StdClass::where('id',$request->class_name)->get();
            foreach($stdclass as $data)
            {
                session()->put('class_name',$data->class_name);
            }

        $sub = Subject::where('sub_name',$request->subject_name)->where('class_id',$request->class_name)->get();
        if($sub->count()>0)
        {
            return redirect()->back()->with('status','The '.$request->subject_name . ' Already exists in class '.session()->get('class_name'));
        }
        else
        {
            
            $sub = new Subject;
            $sub->sub_name = $request->subject_name;
            $sub->class_id = $request->class_name;	 
            $sub->teacher_id = $request->teacher_id;
            
            $save = $sub->save();
            if($save)
            {
                return redirect()->back()->with('status',$request->subject_name.' Added in class '.session()->get('class_name') );
            }
            else
            {
                return redirect()->back()->with('status',$request->subject_name.' Not add in class '.session()->get('class_name')); 
            }
        }    
    }

    public function trash($id, $v)
    {
        if($v == "trash subject")
        {
            $sub = Subject::find($id)->delete();
            if($sub)
            {
                return redirect()->back()->with('status','Subject has been trashed');
            }
            else
            {
                return redirect()->back()->with('status','Subject not trash');
            }
        }
        elseif($v == "trash restore")
        {
            $sub = Subject::withTrashed()->find($id)->restore();
            if($sub)
            {
                return redirect()->back()->with('status','Subject has been restored');
            }
            else
            {
                return redirect()->back()->with('status','Subject not restore');
            }
        }
        elseif($v == "trash delete")
        {
            $sub = Subject::withTrashed()->find($id)->forceDelete();
            if($sub)
            {
                return redirect()->back()->with('status','Subject has been deleted');
            }
            else
            {
                return redirect()->back()->with('status','Subject not delete');
            }
        }
    }

    public function updatesub(Request $request)
    {

        $stdclass = StdClass::where('id',$request->class_name)->get();
            foreach($stdclass as $data)
            {
                session()->put('class_name',$data->class_name);
            }

        $sub = Subject::find($request->sub_id);

        $sub->sub_name = $request->subject_name;
        $sub->class_id = $request->class_name;
        $update = $sub->update();

        if($update)
        {
            return redirect()->back()->with('status','The '.$request->subject_name . ' Updated in class '.session()->get('class_name'));
        }
        else
        {
            return redirect()->back()->with('status','The '.$request->subject_name . ' Not update in class '.session()->get('class_name'));
        }
    }

   public function examAdd(Request $request)
   {
       
       $valide = $request->validate([
           'class'=>'required',
           'subject'=>'required',
           'date'=>'required|date',
           'time'=>'required',
           'hrs'=>'required|min:0|max:24',
           'min'=>'required|min:1|max:60',
           'title'=>'required',
           'description'=>'required',
       ]);

       
       $examtime = new ExamTime;

       $examtime->class = $request->class;
       $examtime->teacher_id = Auth::guard('teacher')->user()->id;
       $examtime->subject = $request->subject;
       $examtime->exam_title = $request->title;
       $examtime->exam_time = $request->time;
       $examtime->exam_date = $request->date;
       $examtime->exam_hr = $request->hrs;
       $examtime->exam_min = $request->min;
       $examtime->exam_description = $request->description;

       $save = $examtime->save();
       if($save)
       {
            return redirect()->back()->with('status','New exam has been added');
        }
        else
        {
           return redirect()->back()->with('status','New exam not add');

       }
   }

   public function manageExam($id)
   {
       $examTime = ExamTime::where('id',$id)->get();
       $examQue  = ExamQuestion::where('exam_id', $id)->get();
        foreach($examQue as $queData)
        {
            session()->put('ExamQueId',$queData->exam_id);
        }
       $clas =  ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
       $stdclass = StdClass::all();
       $sub = Subject::where('teacher_id', Auth::guard('teacher')->user()->id)->get();

       return view('teacher.question',compact('examTime','examQue','clas','stdclass','sub'));
   }

   public function updateExam(Request $request, $id, $v)
   {
        if($v == "update exam")
        {
            $valide = $request->validate([
                'class'=>'required',
                'subject'=>'required',
                'date'=>'required|date',
                'time'=>'required',
                'hrs'=>'required|min:0|max:24',
                'min'=>'required|min:1|max:60',
                'title'=>'required',
                'description'=>'required',
            ]);
     
            $examtime = ExamTime::find($request->examTimeId);
            $examtime->class = $request->class;
            $examtime->teacher_id = Auth::guard('teacher')->user()->id;
            $examtime->subject = $request->subject;
            $examtime->exam_title = $request->title;
            $examtime->exam_time = $request->time;
            $examtime->exam_date = $request->date;
            $examtime->exam_hr = $request->hrs;
            $examtime->exam_min = $request->min;
            $examtime->exam_description = $request->description;

            $update = $examtime->update();   
            if($update)
            {
                    return redirect()->back()->with('status','Exam has been updated');
                }
                else
                {
                return redirect()->back()->with('status','Exam not update');

            }
        }
   }

   public function addQues(Request $request)
   {
       $valid = $request->validate([
           'question' => 'required',
           'choice_A' => 'required',
           'choice_B' => 'required',
           'choice_C' => 'required',
           'choice_D' => 'required',
           'mark' => 'required|digits:1|min:0',
           'correctAnswer' => 'required',
       ]);

       if(($request->correctAnswer == "A") || ($request->correctAnswer == "a"))
       {
           session()->put('answer', 'opt1');
       }
       elseif(($request->correctAnswer == "B") || ($request->correctAnswer == "b"))
       {
           session()->put('answer', 'opt2');
       }
       elseif(($request->correctAnswer == "C") || ($request->correctAnswer == "c"))
       {
           session()->put('answer', 'opt3');
       }
       elseif(($request->correctAnswer == "D") || ($request->correctAnswer == "D"))
       {
           session()->put('answer', 'opt4');
       }

       $examQues = new ExamQuestion;

        $examQues->question = $request->question;
        $examQues->opt1 = $request->choice_A;
        $examQues->opt2 = $request->choice_B;
        $examQues->opt3 = $request->choice_C;
        $examQues->opt4 = $request->choice_D;
        $examQues->answer = session()->get('answer');
        $examQues->ques_num = $request->mark;
        $examQues->exam_id = $request->examId;

        $save = $examQues->save();
        if($save)
        {
            return redirect()->back()->with('status','New question has been added');
        }
        else
        {
            return redirect()->back()->with('status','New question not add');

        }
   }

   public function updateQues(Request $request)
   {
       
            $valid = $request->validate([
                'question' => 'required',
                'choice_A' => 'required',
                'choice_B' => 'required',
                'choice_C' => 'required',
                'choice_D' => 'required',
                'mark' => 'required|digits:1|min:0',
                'correctAnswer' => 'required',
            ]);
     
            if(($request->correctAnswer == "A") || ($request->correctAnswer == "a"))
            {
                session()->put('answer', "opt1");
            }
            elseif(($request->correctAnswer == "B") || ($request->correctAnswer == "b"))
            {
                session()->put('answer', "opt2");
            }
            elseif(($request->correctAnswer == "C") || ($request->correctAnswer == "c"))
            {
                session()->put('answer', "opt3");
            }
            elseif(($request->correctAnswer == "D") || ($request->correctAnswer == "D"))
            {
                session()->put('answer', "opt4");
            }
     
            $examQues = ExamQuestion::find($request->queId);
     
             $examQues->question = $request->question;
             $examQues->opt1 = $request->choice_A;
             $examQues->opt2 = $request->choice_B;
             $examQues->opt3 = $request->choice_C;
             $examQues->opt4 = $request->choice_D;
             $examQues->ques_num = $request->mark;
             $examQues->answer = session()->get('answer');
     
             $update = $examQues->update();
             if($update)
             {
                 return redirect()->back()->with('status','Question has been updated');
             }
             else
             {
                 return redirect()->back()->with('status','Question not update');
     
             }
   }

   public function deleteQues($id, $v)
   {
       if($v == "question delete")
       {
           $que = ExamQuestion::find($id);
           $del = $que->forceDelete();
           if($del)
           {
            return redirect()->back()->with('status','Question has been deleted');
        }
        else
          {
              return redirect()->back()->with('status','Question not delete');
  
          }
       }
   }

   public function examTrash($id)
   {
       $examTime = ExamTime::find($id)->delete();
       if($examTime)
       {
        return redirect()->back()->with('status','Exam has been trash');
        }
      else
        {
            return redirect()->back()->with('status','Exam not trash');

        }
   }

   public function examBackup($id, $v)
   {
        $examTime = ExamTime::onlyTrashed()->find($id);

        if($v == "exam restore")
        {
            $restore = $examTime->restore();
            if($restore)
            {
                return redirect()->back()->with('status','Exam has been restored');
            }
            else{
                
                return redirect()->back()->with('status','Exam not restore');
            }
        }
        elseif($v == "exam delete")
        {
            $delete = $examTime->forceDelete();
            if($delete)
            {
                return redirect()->back()->with('status','Exam has been deleted');
            }
            else{
                
                return redirect()->back()->with('status','Exam not delete');
            }
        }
   }

   public function examSchedule($id, $v)
   {
        $examTime = ExamTime::find($id);

        if($v == "active")
        {
            $examTime->exam_status = "Active";
            $update = $examTime->update();
            if($update)
            {
                return redirect()->back()->with('status','Exam has been activated');
            }
            else
            {
                return redirect()->back()->with('status','Exam not active');

            }
        }
        elseif($v == "deactive")
        {
            $examTime->exam_status = "Deactive";
            $update = $examTime->update();
            if($update)
            {
                return redirect()->back()->with('status','Exam has been deactivated');
            }
            else
            {
                return redirect()->back()->with('status','Exam not deactive');

            }
        }
   }

   public function examinee($v)
   {

     $classTeacher = ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
     $clas = StdClass::all();

     $student = Student::all();

     if($v == "add examinee")
     {
        session()->put('add-examinee', 1);
        session()->forget('trash-examinee', 1);
        return view('teacher.examinee', compact('classTeacher','clas','student'));
    }
    elseif($v == "trash examinee")
    {
        $classTeacher = ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
        $clas = StdClass::all();
        $student = Student::onlyTrashed()->get();

         session()->forget('add-examinee', 1);
         session()->put('trash-examinee', 1);
         return view('teacher.examinee', compact('classTeacher','clas','student'));
        
     }
   }

   public function classData($id)
   {
    $classTeacher = ClassAndTeacher::where('teacher_id', Auth::guard('teacher')->user()->id)->orderBy('id', 'DESC')->get();
    $clas = StdClass::all();
    $stdAnswer = StudentAnswer::all();
    // $stdAnswrUserCount = StudentAnswer::withTrashed()->groupBy('std_id','exam_id')->get();
    // $stdAnswrUserCount = StudentAnswer::withTrashed()->groupBy('std_id','exam_id')->get();
    $stdAnswrUserCount = StudentAnswer::withTrashed()->select('std_id','exam_id')->groupBy('std_id','exam_id')->get();
    // $answer = StudentAnswer::withTrashed()->groupBy('exam_id')->get();

    $subject = Subject::all();
    $examTime = ExamTime::all();
    $examQues = ExamQuestion::all();
    $std = Student::where('class', $id)->where('permission','Yes')->get();
    // $queNumCount = ExamQuestion::select('id','exam_id',DB::raw("SUM(ques_num) as total_num"),DB::raw("COUNT(question) as total_question"))->groupBy('exam_id')->get();
    $queNumCount = ExamQuestion::select('exam_id',DB::raw("SUM(ques_num) as total_num"),DB::raw("COUNT(question) as total_question"))->groupBy('exam_id')->get();
   
    // echo $stdAnswrUserCount;
    // echo "<br>";
    // echo "New line answer";
    // echo "<br>";
   
    // echo "<br>";
    // echo $stdAnswrUserCount1;
    // echo "<br>";
    // echo "New line count que";
    // echo "<br>";
    // echo $queNumCount;
    // echo "<br>";
    // echo "New line couint que1";
    // echo "<br>";
    // echo $queNumCount1;
    
  
   
    foreach($clas as $clasData)
    {
        if($clasData->id == $id)
        {
            session()->put('class_name', $clasData->class_name);
        }
    }

     return view('teacher.class', compact('classTeacher','clas','std','stdAnswer','examQues','stdAnswrUserCount','subject','examTime','queNumCount'));
   }

   public function addExaminee(Request $request)
   {
        $valid = $request->validate([
            'class' => ['required'],
            'name' => ['required','regex:/^[a-zA-Z ]+$/'],
            'email' => 'required|email|unique:students,email',
            'phone' => ['required','digits:10'],
            'dob' => ['required'],
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'gender' => ['required'],
        ],[
            'name.regex'=>'Name should be only string',
            'email.unique'=>'Email already taken by someone!',
            'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',
        ]);

        $class = StdClass::where('id',$request->class)->get();
        foreach($class as $clasData)
        {
            session()->put('addStdClass', $clasData->class_name);
        }

        $student = new Student;

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->class = $request->class;
        $student->dob = $request->dob;
        $student->password = Hash::make($request->password);

        $save = $student->save();
        if($save)
        {
            return redirect()->back()->with('status', 'New examinee has been added in class ' .session()->get('addStdClass'));
        }
        else{
            return redirect()->back()->with('status', 'Examinee not add in class ' .session()->get('addStdClass'));
        }
   }

   public function examineePermission($id, $v)
   {
       $student  = Student::find($id);

       if($v == "examinee allow")
       {
            $student->permission = "Yes";
            $update = $student->update();
            if($update)
            {
                return redirect()->back()->with('status', 'Student has been allowed');
            }
            else
            {
                return redirect()->back()->with('status', 'Student not allow');

            }
       }
       elseif($v == "examinee block")
       {
            $student->permission = "No";
            $update = $student->update();
            if($update)
            {
                return redirect()->back()->with('status', 'Student has been blocked');
            }
            else
            {
                return redirect()->back()->with('status', 'Student not block');

            }
       }
   }

   public function examineeTrash($id)
   {
       $student = Student::find($id)->delete();
       if($student)
       {
        return redirect()->back()->with('status', 'Student has been trashed');
    }
    else{
           return redirect()->back()->with('status', 'Student not trash');
       }
   }

   public function examineeBackUp($id, $v)
   {
       $student = Student::onlyTrashed()->find($id);
       if($v == "examinee restore")
       {
            $restore = $student->restore();
            if($restore)
            {
                return redirect()->back()->with('status', 'Student has been restored');
            }
            else
            {
                return redirect()->back()->with('status', 'Student not restore');
            }
       }
       elseif($v == "examinee delete")
       {
            $restore = $student->forceDelete();
            if($restore)
            {
                return redirect()->back()->with('status', 'Student has been deleted');
            }
            else
            {
                return redirect()->back()->with('status', 'Student not delete');
            }
       }
   }

   public function examineeUpdate(Request $request)
   {
        if($request->password == "")
        {
            $valid = $request->validate([
                'class' => ['required'],
                'name' => ['required','regex:/^[a-zA-Z ]+$/'],
                'email' => 'required|email',
                'phone' => ['required','digits:10'],
                'dob' => ['required'],
                'gender' => ['required'],
            ],[
                'name.regex'=>'Name should be only string',
            ]);
        }
        else
        {
            $valid = $request->validate([
                'class' => ['required'],
                'name' => ['required','regex:/^[a-zA-Z ]+$/'],
                'email' => 'required|email',
                'phone' => ['required','digits:10'],
                'dob' => ['required'],
                'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'gender' => ['required'],
            ],[
                'name.regex'=>'Name should be only string',
                'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',
            ]);
        }

        $student1 = Student::where('email',$request->email)->get();
        foreach($student1 as $data)
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

        $class = StdClass::where('id',$request->class)->get();
        foreach($class as $clasData)
        {
            session()->put('addStdClass', $clasData->class_name);
        }

        $student =  Student::find($request->examineeId);

        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->class = $request->class;
        $student->dob = $request->dob;
        $student->password = session()->get('password');

        $update = $student->update();
        if($update)
        {
            return redirect()->back()->with('status', 'New examinee has been updated in class ' .session()->get('addStdClass'));
        }
        else{
            return redirect()->back()->with('status', 'Examinee not update in class ' .session()->get('addStdClass'));
        }
   }


   public function profile(Request $request)
   {

    if($request->password == "")
    {

        $valid = $request->validate([
            
            'name' => ['required','regex:/^[a-zA-Z ]+$/'],
            'dob' => 'required',
            'phone' => 'required|digits:10',        
            'gender' => 'required',
        ],[
            
            'name.regex'=>'Name should be only string',       
        ]);
    }
    else
    {
        $valid = $request->validate([
            
            'name' => ['required','regex:/^[a-zA-Z ]+$/'],
            'dob' => 'required',
            'phone' => 'required|digits:10',        
            'gender' => 'required',
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ],[
            
            'name.regex'=>'Name should be only string',   
            'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',     
        ]);
    }    

       $teacher = Teacher::where('email', Auth::guard('teacher')->user()->email)->get();
        if($request->hasfile('photo'))
        {
        $file = $request->file('photo');
        $extenstion = $file->getClientOriginalExtension();
        $filename = time().'.'.$extenstion;
        $file->move('images', $filename);
        session()->put('file',$filename);
        }
        else
        {
            foreach($teacher as $data)
            {
                session()->put('file',$data->dp);
                // if($request->password == "")
                // {
                //     session()->put('password',$data->password);
                // }
                // else
                // {
                //     $p = Hash::make($request->password);
                //     session()->put('password',$p);
                // }
            }
        } 

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
        
        $teacherUpdate = Teacher::find(Auth::guard('teacher')->user()->id);

        $teacherUpdate->name = $request->name;
        $teacherUpdate->phone = $request->phone;
        $teacherUpdate->dob = $request->dob;
        $teacherUpdate->password = session()->get('password');
        $teacherUpdate->dp = session()->get('file');
        $teacherUpdate->gender = $request->gender;

        $update = $teacherUpdate->update();
         if($update)
            {
                return redirect()->back()->with('status', 'Teacher profile has been updated');
            }
            else
            {
                return redirect()->back()->with('status', 'Teacher profile  not update');
            }

   }

   public function examDone($id, $v)
   {
       $exam =  ExamTime::find($id);
       if($v == "Yes")
        {
            $exam->exam_done = "Yes";
            $update = $exam->update();
            if($update)
            {
                return redirect()->back()->with('status','Updated exam has been completed');
            }
            else{
                return redirect()->back()->with('status','Update exam not complete');
            }
        }
     elseif($v == "No")
        {
            $exam->exam_done = "No";
            $update = $exam->update();
            if($update)
            {
                return redirect()->back()->with('status','Updated still student can give exam');
            }
            else{
                return redirect()->back()->with('status','Update still student cant give exam');
            }
        }
   }

   public function fetchData()
   {
       $exam = ExamTime::where('teacher_id',Auth::guard('teacher')->user()->id)->get();
       $examActive = ExamTime::where('teacher_id',Auth::guard('teacher')->user()->id)->where('exam_status','Active')->get();
       $examDeactive = ExamTime::where('teacher_id',Auth::guard('teacher')->user()->id)->where('exam_status','Deactive')->get();
       $examDone1 = ExamTime::where('teacher_id',Auth::guard('teacher')->user()->id)->where('exam_done','Yes')->get();
       
       $examCount = $exam->count();
       $examCountActive = $examActive->count();
       $examCountDeactive = $examDeactive->count();
       $examDone = $examDone1->count();

    return response()->json([
        'examCount' => $examCount,
        'examCountActive' => $examCountActive,
        'examCountDeactive' => $examCountDeactive,
        'examDone' => $examDone,
        
    ]);
   }
}
