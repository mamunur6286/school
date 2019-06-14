<?php

class Student
{
    /*Get Students*/
    public function getStudents($table)
    {
        $query = "SELECT * FROM $table";
        $data = DB::select($query);
        return $data;
    }

    public function getStudentBySearch($key, $table)
    {
        $query = "SELECT * FROM $table WHERE roll LIKE '%$key%' OR student_name LIKE '%$key%'";
        $data = DB::select($query);
        return $data;
    }

    public function getClassTenStudentsByGroup($table, $group)
    {
        $query = "SELECT * FROM $table WHERE stu_group = '$group'";
        $data = DB::select($query);
        return $data;
    }

    public function getClassTenGroupStudentsBySearch($key, $group, $table)
    {
        $query = "SELECT * FROM $table WHERE stu_group = '$group' AND (roll LIKE '%$key%' OR student_name LIKE '%$key%')";
        $data = DB::select($query);
        return $data;
    }

    /*Student Books*/
    public function bookList($class, $class_group = null)
    {
        if ($class == 'Ten' OR $class == 'Nine') {
            $query = "SELECT * FROM books WHERE class_name = '$class' AND class_group = '$class_group'";
        } else {
            $query = "SELECT * FROM books WHERE class_name = '$class'";
        }

        $data = DB::select($query);
        return $data;
    }

    public function distinctClassFromBooks($start_from, $per_page)
    {
        $query = "SELECT DISTINCT class_name, class_group FROM books LIMIT $start_from, $per_page";
        $data = DB::select($query);
        return $data;
    }

    public function bookSearchByClass($key)
    {
        $query = "SELECT DISTINCT class_name, class_group FROM books WHERE class_name LIKE '%$key%'";
        $data = DB::select($query);
        return $data;
    }

    public function totalBooks()
    {
        $query = "SELECT DISTINCT class_name, class_group FROM books";
        $data = DB::select($query);
        $rows = $data->num_rows;
        return $rows;
    }

    /*Student Routine*/
    public function distinctClassFromRoutine($start_from, $per_page)
    {
        $query = "SELECT DISTINCT class_name, class_group FROM routine LIMIT $start_from, $per_page";
        $data = DB::select($query);
        return $data;
    }

    public function classRoutine($class, $class_group = null)
    {
        if ($class == 'Ten' OR $class == 'Nine') {
            $query = "SELECT * FROM routine WHERE class_name = '$class' AND class_group = '$class_group'";
        } else {
            $query = "SELECT * FROM routine WHERE class_name = '$class'";
        }

        $data = DB::select($query);
        return $data;
    }

    public function routineSearchByClass($key)
    {
        $query = "SELECT DISTINCT class_name, class_group FROM routine WHERE class_name LIKE '%$key%'";
        $data = DB::select($query);
        return $data;
    }

    public function totalRoutine()
    {
        $query = "SELECT DISTINCT class_name, class_group FROM routine";
        $data = DB::select($query);
        $rows = $data->num_rows;
        return $rows;
    }

    public function routineClassTime()
    {
        $query = "SELECT * FROM routine_class_time";
        $data = DB::select($query)->fetch_assoc();
        return $data;
    }

    /*Student Result*/
    public function checkStudentInfo($data)
    {
        $exam_type = mysqli_real_escape_string(DB::connection(), $data['exam-type']);
        $roll = mysqli_real_escape_string(DB::connection(), $data['roll']);
        $class = mysqli_real_escape_string(DB::connection(), $data['class']);
        $group = mysqli_real_escape_string(DB::connection(), $data['group']);

        $captcha_sum = mysqli_real_escape_string(DB::connection(), $data['captcha-sum']);
        $captcha = mysqli_real_escape_string(DB::connection(), $data['captcha']);
        

        if (empty($exam_type) || empty($roll) || empty($class) || empty($captcha)) {
            return "Please fill out all field !!";
        } else if ($captcha_sum != $captcha) {
            return "Summation was incorrect !!";
        } else if (($class == 'Nine' && empty($group)) || $class == 'Ten' && empty($group)) {
            return "Please fill out group field for class Nine or Ten !!";
        } else {
            $_SESSION['exam-type'] = $exam_type;
            $_SESSION['roll'] = $roll;
            $_SESSION['class'] = $class;
            $_SESSION['group'] = $group;

            echo "<script>window.location = 'student-result'</script>";
        }

    }

    public function getStudentResult()
    {
        $exam_type = $_SESSION['exam-type'];
        $roll = $_SESSION['roll'];
        $class = $_SESSION['class'];
        $group = $_SESSION['group'];

        $result_table = $this->studentClassConvertToTableName($class, 'results');
        $student_table = $this->studentClassConvertToTableName($class, 'students');

        if (!empty($group)) {
            $result_query = "SELECT * FROM $result_table WHERE roll='$roll' AND stu_group='$group'";
            $gpa_query = "SELECT AVG(point) AS avg_point FROM $result_table WHERE roll='$roll' AND stu_group='$group'";
            $studentInfoQuery = "SELECT * FROM $student_table WHERE roll='$roll' AND stu_group='$group'";
        } else {
            $result_query = "SELECT * FROM $result_table WHERE roll='$roll'";
            $gpa_query = "SELECT AVG(point) AS avg_point FROM $result_table WHERE roll='$roll'";
            $studentInfoQuery = "SELECT * FROM $student_table WHERE roll='$roll'";
        }

        $student_result = DB::select($result_query);
        $student_info = DB::select($studentInfoQuery);
        $gpa = DB::select($gpa_query)->fetch_assoc();

        session_destroy();

        return [
            'student_result' => $student_result,
            'student_info' => $student_info->fetch_assoc(),
            'exam_type' => $exam_type,
            'student-class' => $class,
            'gpa' => $gpa['avg_point']
        ];
    }

    private function studentClassConvertToTableName($class, $table_part)
    {
        switch ($class) {
            case 'Six':
                $table = "class_six_$table_part";
                break;
            case 'Seven':
                $table = "class_seven_$table_part";
                break;
            case 'Eight':
                $table = "class_eight_$table_part";
                break;
            case 'Nine':
                $table = "class_nine_$table_part";
                break;
            case 'Ten':
                $table = "class_ten_$table_part";
                break;
            default:
                $table = null;
        }
        return $table;
    }

    // Online application for admission
    public function onlineAdmissionApply($data, $file)
    {

        $first_name = mysqli_real_escape_string(DB::connection(), $data['first_name']);
        $last_name = mysqli_real_escape_string(DB::connection(), $data['last_name']);
        $father_name = mysqli_real_escape_string(DB::connection(), $data['father_name']);
        $mother_name = mysqli_real_escape_string(DB::connection(), $data['mother_name']);
        $gender = mysqli_real_escape_string(DB::connection(), $data['gender']);
        $birth_date = mysqli_real_escape_string(DB::connection(), $data['birth_date']);
        $mobile = mysqli_real_escape_string(DB::connection(), $data['mobile']);
        $village = mysqli_real_escape_string(DB::connection(), $data['village']);
        $union = mysqli_real_escape_string(DB::connection(), $data['union']);
        $sub_district = mysqli_real_escape_string(DB::connection(), $data['sub-district']);
        $district = mysqli_real_escape_string(DB::connection(), $data['district']);

        $image_name = $file['image']['name'];
        $image_tmp = $file['image']['tmp_name'];
        $image_size = $file['image']['size'];

        $divide_extention = explode('.', $image_name);
        $file_extention = strtolower(end($divide_extention));
        $unique_name = substr(md5(time()), 0, 3) . "." . $file_extention;
        $uploaded_image = "../soft/upload/" . $divide_extention[0] . "_" . $unique_name;

        $uniqueApplicationVerifyByMobile_query = "SELECT mobile FROM online_admission WHERE mobile='$mobile'";
        $uniqueApplication = DB::select($uniqueApplicationVerifyByMobile_query);

        if (empty($first_name) || empty($last_name) || empty($father_name) || empty($mother_name) || empty($birth_date) ||empty($gender) || empty($mobile) || empty($village) || empty($union) || empty($sub_district) || empty($district)) {
            return "<div class='alert alert-warning text-center font-weight-normal'>Fields must not be empty.</div>";
        }else{

            if ($uniqueApplication->num_rows > 0){
                return "<div class='alert alert-warning text-center font-weight-normal'>Sorry! You have applied before.</div>";
            } else {
                $student_name = $first_name . ' ' . $last_name;
                $address = $village.','.$union.','.$sub_district.','.$district;

                move_uploaded_file($image_tmp, $uploaded_image);

                $query = "INSERT INTO online_admission(student_name, father_name, mother_name, gender, image, birth_date, mobile, address)
                      VALUE ('$student_name', '$father_name', '$mother_name', '$gender', '$uploaded_image', '$birth_date', '$mobile', '$address')";

                $insert = DB::insert($query);

                $last_id_query = "SELECT MAX(id) AS last_id FROM online_admission";
                $last_insert_id = DB::select($last_id_query)->fetch_assoc();

                if ($insert) {
                    $_SESSION['online-apply-id'] = $last_insert_id['last_id'];
                    
                    /*$sending_msg = "Thanks! Your application has been successfull. You have got an ID. Your Id is : (5). This ID will be needed for admission exam.
                    \n ** School Authority, \n Polytechnic secondary school  \n Kurigram - 5600";
                    $this->sendSms($mobile, $sending_msg);*/
                    
                    echo "<script>window.location='online-admission-apply-report'</script>";
                } else {
                    return "<div class='alert alert-warning text-center font-weight-normal'>Sorry! Something went wrong. Application Not submitted.</div>";
                }
            }
        }

    }

    public function onlineAdmissionApplicantId($id)
    {
        $query = "SELECT * FROM online_admission WHERE id='$id'";
        $data = DB::select($query)->fetch_assoc();
        return $data;
    }
    
    public function sendSms($mobile,$text)
    {
        // Register your ip first. To do that, contact bpl personnel
        $url = 'http://users.sendsmsbd.com/smsapi?';
        $fields = array(
            'api_key' => urlencode('C20025155bdc51935f1fa6.57313350'),
            'type' => urlencode('text'),
            'contacts' => urlencode($mobile),
            'senderid' => '8804445629106',
            'msg' => $text
        );
        $fields_string='';
        foreach($fields as $key=>$value){
            $fields_string .= $key.'='.$value.'&';
        }

        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);

        // If you have proxy
        // $proxy = '<proxy-ip>:<proxy-port>';
        // curl_setopt($ch, CURLOPT_PROXY, $proxy);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);

        if($result === false)
        {
            echo sprintf('<span>%s</span>CURL error:', curl_error($ch));
            return;
        }

        curl_close($ch);
    }


}