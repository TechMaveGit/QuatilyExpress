<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use App\Models\Persons;

use App\Models\Personaddress;

use App\Models\Personreminder;

use App\Models\Personrates;

use App\Models\Roles;

use App\Models\Admin;

use Hash;

use App\Models\Driver;

use App\Models\Type;

use App\Models\Persondocument;

use App\Models\Reminders;



use Illuminate\Http\Request;

use Redirect;

class Personcontroller extends Controller

{

    public function person(Request $request)
    {

      $data['status']=$request->input('selectStatus');

      $data['name']=$request->input('name');

      $data['email']=$request->input('email');


      $query=Driver::select('*')->orderBy('id','DESC');


        if($data['name'])
        {
            $query=$query->where('userName', 'like', '%'.$data['name'].'%');
        }

        if($data['email'])
        {
            $query=$query->where('email',$data['email']);
        }

        if($data['status'])
        {
        $query=$query->where('status',$data['status']);
        }
        else{
            $query=$query->where('status','1');
        }

        $data['person']=$query->get();

      return view('admin.person.person',$data);

    }



    public function personAdd(Request $request)

    {

        if(request()->isMethod("post"))
        {


            $this->validate($request, [
                'email' => 'required|email|unique:drivers,email',
            ]);

            $input = $request->all();

            $name       = $request->input('name');

            $shortName  = $request->input('surname');

            $email        = $request->input('email');

            $dob        = $request->input('dob');

            $role        = $request->input('roles');

            $phoneprinciple      = $request->input('phoneprinciple');

            $phoneaux = $request->input('phoneaux');

            $tfn = $request->input('tfn');

            $abn   = $request->input('abn');

            $selectPersion    = $request->input('selectPersion');

            $password    = $request->input('password');

            $persion   = Driver::insertGetId([

                                                    'fullName'           => $name,

                                                    'userName'           => $name,

                                                    'surname'        => $shortName,

                                                    'email'          => $email,

                                                    'dob'            => $dob,

                                                    'phonePrincipal' => $phoneprinciple,

                                                    'phoneAux'       => $phoneaux,

                                                    'tfn'            => $tfn,

                                                    'abn'            => $abn,

                                                    'role_id'        => $input['roles'],

                                                    'status'            => '1',

                                                    'password'       => Hash::make($password),

                                                    'selectPersonType' => $selectPersion,

                                                ]);

               if($input['roles'])
               {
                    $request->request->remove('_token');
                    $input['name']        = $name;
                    $input['email']       = $email;
                    $input['role_id']     = $input['roles'];
                    $input['password']    = Hash::make($input['password']);
                    $input['added_date']  = date("j F, Y");
                    $user = Admin::create($input);
               }
               return redirect()->route('person')->with('message', 'Persion Basic Information Added Successfully!!');

        }


          $roles = Roles::where('name','!=','my permission')->where('status','1')->orderBy('id','DESC')->get();
      return view('admin.person.person-add',compact('roles'));

    }



    public function personview(Request $request,$id)

    {

        $data['personDetail']=Driver::orderBy('id','DESC')->with(['getaddress','getreminder.getReminder'=> function ($query)

        {

            $query->select('id','reminderName');

        }

        ])->where('id',$id)->first();


        $data['documents']= Persondocument::orderBy('id','DESC')->where('personId',$id)->get();



         return view('admin.person.person-view',$data);

    }



    public function personedit( Request $request,$id)
    {
          $data['person'] =$id;
          $personValue1=$request->input('personValue1');

           $roles=$request->input('roles');
           $role_data= Roles::where('id',$roles)->first()->id??'1000';

          if($personValue1)
          {

        //    return $request->all();

            $name           = $request->input('name');
            $shortName      = $request->input('surname');
            $email          = $request->input('email');
            $dob            = $request->input('dob');
            $phoneprinciple = $request->input('phoneprinciple');
            $phoneaux       = $request->input('phoneaux');
            $tfn            = $request->input('tfn');
            $abn            = $request->input('abn');
            $selectPersion  = $request->input('selectPersion');
            $password       = $request->input('password');

            if($password)
            {
             $password=Hash::make($password);
            }
            else{
            $password=Driver::where('email',$email)->first()->password;
            }

            $data   = array(
                                'userName'       => $name,
                                'surname'        => $shortName,
                                'email'          => $email,
                                'dob'            => $dob,
                                'phonePrincipal' => $phoneprinciple,
                                'phoneAux'       => $phoneaux,
                                'tfn'            => $tfn,
                                'abn'            => $abn,
                                'role_id'        => $role_data,
                                'password'       => $password,
                                'selectPersonType' => $selectPersion,
                            );

              Driver::whereId($id)->update($data);


             if($role_data)
             {
               $adminGmail=Admin::where('email',$email)->first();
                if($adminGmail)
                {
                    $data = [
                        'email' => $email,
                        'name' => $name,
                        'role_id' => $role_data,
                        'password' =>$password
                    ];
                   Admin::where('email',$email)->update($data);
                }
                else{
                    $data = [
                        'email' => $email,
                        'name' => $name,
                        'role_id' => $role_data,
                        'password' =>$password
                    ];
                   Admin::where('email',$email)->insert($data);

                }



            }
              return Redirect::back()->with('message', 'Person Basic Information Updated Successfully!');
          }

          $personValue2=$request->input('personValue2');
          if($personValue2=='2')
          {
             $Personaddress= Personaddress::insertGetId([

                            'personId'      => $request->input('personId'),
                            'zipCode'       => $request->input('zipCode')??'0',
                            'unit'          => $request->input('unit')??'0',
                            'addressNumber' => $request->input('addressNumber')??'0',
                            'streetAddress' => $request->input('streetAddress')??'0',
                            'suburb'        => $request->input('suburb')??'0',
                            'city'          => $request->input('city')??'0',
                            'state'         => $request->input('state')??'0',
                                            ]);
              $Personaddress= Personaddress::orderBy('id','DESC')->where('id',$Personaddress)->first();
              return response()->json([
                                        'success'=>'200',
                                      'message'=>'Personaddress saved successfully.',
                                      'data'   => $Personaddress
                                      ]);

          }


          $personValue3=$request->input('personValue3');
          if($personValue3=='3')
          {
               $Personaddress= Personreminder::insertGetId([
                                                  'personId'          => $request->input('personId'),
                                                  'reminderType'      => $request->input('reminderType'),
                                            ]);
                $Personaddress= Personreminder::orderBy('id','DESC')->where('id',$Personaddress)->first();
                $Personaddress->typeName=Reminders::select('reminderName')->whereId($Personaddress->reminderType)->first()->reminderName;
                return response()->json([
                                        'success'=>'200',
                                        'message'=>'Personaddress reminder successfully.',
                                        'data'   => $Personaddress
                                    ]);
          }



          $personValue4=$request->input('personValue4');
          if($personValue4=='4')
          {
              $checkPersonrates=Personrates::where('personId',$request->input('personId'))->where('type',$request->input('type'))->first();
              if($checkPersonrates)
              {
                    $Personaddress= Personrates::where('personId',$request->input('personId'))->where('type',$request->input('type'))->update([
                                                      'personId'  =>$request->input('personId'),
                                                      'type'      =>$request->input('type'),
                                                      'hourlyRatePayableDays'          => $request->input('hourlyRatePayableDay') ??  $checkPersonrates->hourlyRatePayableDays,
                                                      'hourlyRatePayableNight'      => $request->input('hourlyRatePayableNight') ?? $checkPersonrates->hourlyRatePayableNight,
                                                      'hourlyRatePayableSaturday'      => $request->input('hourlyRatePayableSaturday') ??  $checkPersonrates->hourlyRatePayableSaturday,
                                                      'hourlyRatepayableSunday'      => $request->input('hourlyRatePayableSunday') ?? $checkPersonrates->hourlyRatepayableSunday,
                                                      'extraHourlyRate'      => $request->input('extraHourlyRate') ?? $checkPersonrates->extraHourlyRate,
                                                ]);

                    $Personaddress= $checkPersonrates->id;
                    $Personaddress= Personrates::orderBy('id','DESC')->where('id',$Personaddress)->first();
                    $Personaddress->dropdowntype= Type::orderBy('id','DESC')->where('id',$Personaddress->type)->first()->name??'N/A';

                     return response()->json([
                                            'success'=>'300',
                                            'message'=>'Person rate updated successfully.',
                                            'data'   => $Personaddress
                                        ]);

              }
              else
                 {
                   $Personaddress= Personrates::insertGetId([
                                                      'personId'  =>$request->input('personId'),
                                                      'type'      =>$request->input('type'),
                                                      'hourlyRatePayableDays'          => $request->input('hourlyRatePayableDay')??'0',
                                                      'hourlyRatePayableNight'      => $request->input('hourlyRatePayableNight')??'0',
                                                      'hourlyRatePayableSaturday'      => $request->input('hourlyRatePayableSaturday')??'0',
                                                      'hourlyRatepayableSunday'      => $request->input('hourlyRatePayableSunday')??'0',
                                                      'extraHourlyRate'      => $request->input('extraHourlyRate')??'0',
                                                ]);
                    $Personaddress= Personrates::orderBy('id','DESC')->where('id',$Personaddress)->first();
                    $Personaddress->dropdowntype= Type::orderBy('id','DESC')->where('id',$Personaddress->type)->first()->name;
                    return response()->json([
                                            'success'=>'200',
                                            'message'=>'Person rate created successfully.',
                                            'data'   => $Personaddress
                                        ]);
                   }
           }

          $personValue5=$request->input('personValue5');
          if($personValue5=='5')
          {

            if($request->file('document_file')!=''){
              $image = $request->file('document_file');
              $new_name = rand() . '.' . $image->getClientOriginalExtension();
              $image->move(public_path('assets/person-document'), $new_name);
          }

          $documentData = [
            'personId' => $request->input('person_id'),
            'name' => $request->input('document_name'),
            'status' => $request->input('document_status'),
            'document' => $new_name ?? null,
        ];

        PersonDocument::insert($documentData);

                $documents= Persondocument::orderBy('id','DESC')->where('personId',$request->input('person_id'))->get();

                return response()->json([
                                        'success'=>'200',
                                        'message'=>'Persondocument added successfully.',
                                        'documents'   => $documents
                                    ]);

          }


      $data['editPerson']=Driver::orderBy('id','DESC')->with(['getaddress','getreminder.getReminder'])->where('id',$id)->first();

      $data['personRating']= Personrates::orderBy('id','DESC')->where('personId',$id)->get();

      $data['Personreminder'] =Personreminder::orderBy('id','DESC')->where('status','1')->get();

      $data['reminder'] =Reminders::orderBy('id','DESC')->where('status','1')->get();


      $data['types'] =Type::orderBy('id','DESC')->where('status','1')->get();

      return view('admin.person.person-edit',$data);

    }


    public function editPersonId(Request $request)
    {

    //    return $request->all();

            $Personaddress= Personrates::where('personId',$request->input('personId'))->where('type',$request->input('typeiD'))->update([
                                                    'personId'  =>$request->input('personId'),
                                                    'type'      =>$request->input('vehicleType'),
                                                    'hourlyRatePayableDays'          => $request->input('hourlyRatePayableDay')??'0',
                                                    'hourlyRatePayableNight'      => $request->input('hourlyRatePayableNight')??'0',
                                                    'hourlyRatePayableSaturday'      => $request->input('hourlyRatePayableSaturday')??'0',
                                                    'hourlyRatepayableSunday'      => $request->input('hourlyRatePayableSunday')??'0',
                                                    'extraHourlyRate'      => $request->input('extraHourlyRate')??'0',
                                                ]);

              return redirect()->back()->with('message', 'Person Rate Updated  Successfully!!');


}






    public function Persondocument(Request $request)

    {

        $id=$request->input('personId');

        $deleteData=Persondocument::whereId($id)->delete();

        if($deleteData)

        {

            return response()->json([

                        'success'=>'200',

                        'message'=>'Person Document Deleted  successfully.',

                    ]);

        }

    }



    public function deleteaddress(Request $request)

    {

        $id=$request->input('personId');

        $deleteData=Personaddress::whereId($id)->delete();

        if($deleteData)

        {

            return response()->json([

                        'success'=>'200',

                        'message'=>'Person Address Deleted  successfully.',

                    ]);

        }

    }



    public function reminderPerson(Request $request)

    {

        $id=$request->input('personId');

        $deleteData=Personreminder::whereId($id)->delete();

        if($deleteData)

        {

            return response()->json([

                        'success'=>'200',

                        'message'=>'Person Reminder Deleted  successfully.',

                    ]);

        }

    }



    public function deleteRate(Request $request)

    {

        $id=$request->input('personId');

        $deleteData=Personrates::whereId($id)->delete();

        if($deleteData)

        {

            return response()->json([

                        'success'=>'200',

                        'message'=>'Person Rates Deleted  successfully.',

                    ]);

        }

    }

    public function deletePerson(Request $request)

    {
        $id=$request->input('common');
        $deleteData=Driver::whereId($id)->update(['status'=>'2']);

        if($deleteData)
        {
            return Redirect::back()->with('message', 'Person Delete Successfully.!');
        }

    }
    public function personStatus(Request $request)

    {

      $person=Driver::whereId($request->input('personId'))->update(['status'=>$request->input('statusValue')]);
      $driverDetail=Driver::whereId($request->input('personId'))->first()->email ?? 0;
      $driverDetail=Admin::where('email',$driverDetail)->update(['status'=>$request->input('statusValue')]);

      if($person)

      {

        return response()->json([

            'success'=>'200',

            'message'=>'Done.',

        ]);

      }

    }







}



