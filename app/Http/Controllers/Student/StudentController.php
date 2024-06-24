<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StdClass;
use App\Models\ExamTime;
use App\Models\Teacher;
use App\Models\ExamQuestion;
use App\Models\StudentAnswer;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function index()
    {
        $clas = StdClass::all();
        return view('student.register',compact('clas'));
    }

    public function create(Request $request)
    {
        $valid = $request->validate(
            [
            'name' => ['required','regex:/^[a-zA-Z ]+$/'],
            'email' => 'required|email|unique:students,email',
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'phone' => ['required','digits:10'],
            'gender' => 'required',
            'dob' => 'required',
            'class' => 'required',
          ],[
            'name.regex'=>'Name should be only string',
            'password.regex'=>'Password must be 1 capital, 1 small and 1 digit',
            'email.unique'=>'Email already taken',
          ]);

        $student = new Student;

        $student->name = $request['name'];
        $student->email = $request['email'];
        $student->password = Hash::make($request['password']);
        $student->phone = $request['phone'];
        $student->gender = $request['gender'];
        $student->class = $request['class'];
        $student->dob = $request['dob'];

        $save = $student->save();

        if($save)
        {
            return redirect()->back()->with('status','Registeration successfull');
        }
        else
        {
            return redirect()->back()->with('status','Registeration not successfull');
        }

        // echo $request['name'];
        // echo "<br>";
        // echo $request['email'];
        // echo "<br>";
        // echo $request['dob'];
        // echo "<br>";
        // echo $request['class'];
        // echo "<br>";
        // echo $request['gender'];
        // echo "<br>";
        // echo $request['phone'];
        // echo "<br>";
        // echo $request['password'];
        // echo "<br>";
        
    }

    public function check(Request $request)
    {
        $valid = $request->validate([
            
            'email'=> 'required|email|exists:students,email',
            'password' => ['required','min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ],[
            'password.regex'=>'The Password Must Be 1 Capital, 1 Small and 1 Digit',
            'email.exists'=>'The Email Is Not Exists',
        ]);

        $student = Student::where('email',$request->email)->where('permission','Yes')->get();
        foreach($student as $data)
        {
            session()->put('count',Hash::check($request['password'],$data->password));
        }
        
        

        if(($student->count() == 1))
        {
           if((session()->get('count') == 1))
           {
                if (Auth::guard('student')->attempt($request->only('email','password')))
                {
                    return redirect()->route('student.home');
                }
           }
           else
           {
            return redirect()->back()->with('status','Wrong password');
           }           
        }
        else
        {
            return redirect()->back()->with('status','Dear Student Teacher Not Allow You');
        }    
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login');
    }

    public function show($v)
    {
        
        $subject = Subject::where('class_id',Auth::guard('student')->user()->class)->get();
        $clas = StdClass::all();
        // $examTime = ExamTime::where('class',Auth::guard('student')->user()->class)->get();

        $examTime = ExamTime::where('class',Auth::guard('student')->user()->class)
                            ->whereNotIn('id', function($data){
                                        $data->select('exam_id')->from('exam_attempts')->where('std_id',Auth::guard('student')->user()->id);
                                        })->withTrashed()->get();

       
        $teacher = Teacher::all();
        $examAtmpt = ExamAttempt::where('std_id',Auth::guard('student')->user()->id)->get();
        if($v == "available exam")
        {
            session()->put('exam',1);
            session()->forget('taken_exam',1);
            session()->forget('not_taken_exam',1);
            session()->forget('result',1);
            session()->forget('feedback',1);

            return view('student.show',compact('subject','clas','examTime','teacher','examAtmpt'));
        }
        elseif($v == "taken exam")
        {
            $examTime = ExamTime::where('class',Auth::guard('student')->user()->class)
                            ->whereIn('id', function($data){
                                        $data->select('exam_id')->from('exam_attempts')->where('status','Yes')->where('std_id',Auth::guard('student')->user()->id);
                                        })->withTrashed()->get();
            $examTimeNotSubmit = ExamTime::where('class',Auth::guard('student')->user()->class)
                            ->whereIn('id', function($data){
                                        $data->select('exam_id')->from('exam_attempts')->where('status','No')->where('std_id',Auth::guard('student')->user()->id);
                                        })->withTrashed()->get();
           
            session()->forget('exam',1);
            session()->put('taken_exam',1);
            session()->forget('not_taken_exam',1);
            session()->forget('result',1);
            session()->forget('feedback',1);
            
             return view('student.show',compact('subject','clas','examTime','teacher','examAtmpt','examTimeNotSubmit'));
        }
        elseif($v == "not taken exam")
        {
            session()->forget('exam',1);
            session()->forget('taken_exam',1);
            session()->put('not_taken_exam',1);
            session()->forget('result',1);
            session()->forget('feedback',1);
            return view('student.show',compact('subject','clas','examTime','teacher','examAtmpt'));
        }
        
    }

    public function preExam($id)
    {
        $subject = Subject::where('class_id',Auth::guard('student')->user()->class)->get();
        $exam = ExamTime::where('id',$id)->get();
        $ques = ExamQuestion::where('exam_id',$id)->get();
        $queCount = $ques->count();
        return view('student.exam-guide',compact('exam','subject','ques','queCount'));
    }

   public function examStart($id)
   {
      $question = ExamQuestion::where('exam_id',$id)->get();
      $queCount = $question->count();
      $exam = ExamTime::where('id',$id)->get();
      foreach($exam as $data)
      {
          session()->put('hr',$data->exam_hr);
          session()->put('min',$data->exam_min);
          session()->put('date',$data->exam_date);
          session()->put('time',$data->exam_time);
          session()->put('examId',$data->id);
      }
      return view('student.question', compact('question','queCount')); 
   }
    

   public function que(Request $request)
   { 

    $answerCheck = StudentAnswer::where('std_id',Auth::guard('student')->user()->id)->where('exam_id',$request->examId)->where('question_id',$request->queId)->get();
    $examAttempt = ExamAttempt::where('std_id',Auth::guard('student')->user()->id)->where('exam_id',$request->examId)->get(); 
    if($examAttempt->count() == 0)
    {
        $examAttempt1 = new ExamAttempt;
        $examAttempt1->std_id = Auth::guard('student')->user()->id;
        $examAttempt1->exam_id = $request->examId;
        $examAttempt1->save();
    }

    if($answerCheck->count() == 0)
    {
        $insertAnswer = new StudentAnswer;
        $insertAnswer->std_id = Auth::guard('student')->user()->id;
        $insertAnswer->exam_id = $request->examId;
        $insertAnswer->question_id = $request->queId;
        $insertAnswer->std_answer = $request->option;
        $save = $insertAnswer->save();

    }
    else
    {
       $answerUpdate = StudentAnswer::where('std_id',Auth::guard('student')->user()->id)
                                    ->where('exam_id',$request->examId)
                                    ->where('question_id',$request->queId)
                                    ->update([
                                        'std_answer' => $request->option,
                                    ]);
    }

    return response()->json([
        'game' =>'success',
        
    ]);
   }

  public function examSubmit(Request $request)
  {
    $examAttempt = ExamAttempt::where('std_id',$request->stdId)
                              ->where('exam_id',$request->examId)
                              ->update([
                                  'status'=>'Yes'
                              ]);
   
    return redirect()->route('student.home')->with('status','Exam Has Been Completed');                          
      
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

      $student = Student::where('email', Auth::guard('student')->user()->email)->get();
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
           foreach($student as $data)
           {
               session()->put('file',$data->dp);
           }
       } 

       foreach($student as $data)
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
       
       $studentUpdate = Student::find(Auth::guard('student')->user()->id);

       $studentUpdate->name = $request->name;
       $studentUpdate->phone = $request->phone;
       $studentUpdate->dob = $request->dob;
       $studentUpdate->password = session()->get('password');
       $studentUpdate->dp = session()->get('file');
       $studentUpdate->gender = $request->gender;

       $update = $studentUpdate->update();
        if($update)
           {
               return redirect()->back()->with('status', 'Student profile has been updated');
           }
           else
           {
               return redirect()->back()->with('status', 'Student profile  not update');
           }

  }

  public function fetch()
  {
    $class = StdClass::where('id', Auth::guard('student')->user()->class)->get();
    $cls;
    $notGiven = 0;
    $examAttmpt1 = ExamAttempt::where('std_id',Auth::guard('student')->user()->id)->where('status','Yes')->get();
    $examAttmpt2 = ExamAttempt::where('std_id',Auth::guard('student')->user()->id)->where('status','No')->get();

    $examAttmptDone = $examAttmpt1->count();
    $examAttmptNotDone = $examAttmpt2->count();

    foreach($class as $data)
    {
        $cls = $data->class_name;
    }

    // 
    $subject = Subject::where('class_id',Auth::guard('student')->user()->class)->get();
    $clas = StdClass::all();
        // $examTime = ExamTime::where('class',Auth::guard('student')->user()->class)->get();

    $examTime = ExamTime::where('class',Auth::guard('student')->user()->class)
                            ->whereNotIn('id', function($data){
                                        $data->select('exam_id')->from('exam_attempts')->where('std_id',Auth::guard('student')->user()->id);
                                        })->withTrashed()->get();

       
    $teacher = Teacher::all();
    $examAtmpt = ExamAttempt::where('std_id',Auth::guard('student')->user()->id)->get();
    foreach($examTime as $examdata)
    {
            foreach($clas as $clasdata)
            {
                if($examdata->class == $clasdata->id)
                {
                    foreach($subject as $subdata)
                    {
                        if($examdata->subject == $subdata->id)
                        {
                            foreach($teacher as $teacherData)
                           {
                            if($teacherData->id == $examdata->teacher_id)
                            {
                                $notGiven++;
                            }
                           }
                        }
                    }
                }
            }                           
   }

    return response()->json([
        'class' => $cls,
        'examDone' =>$examAttmptDone,
        'examNotDone' =>$examAttmptNotDone,
        'NotGiven' =>$notGiven,

    ]);
  }
}
