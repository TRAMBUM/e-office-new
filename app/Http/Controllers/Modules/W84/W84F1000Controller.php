<?php

namespace App\Http\Controllers\Modules\W84;

use App\Http\Controllers\Controller;
use App\Models\D76T1556;
use App\Models\D76T2140;
use App\Models\D76T2141;
use App\Models\D76T2280;
use App\Models\D76T2281;
use App\Models\D76T2282;
use App\Models\D76T2300;
use App\Models\D76T2301;
use App\Models\D76T9020;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class  W84F1000Controller extends Controller
{
    private $d76T1556;
    private $d76T2300;
    private $d76T2301;
    private $d76T2280;
    private $d76T2281;
    private $d76T2282;

    public function __construct(D76T1556 $d76T1556, D76T2300 $d76T2300, D76T2301 $d76T2301, D76T2280 $d76T2280, D76T2281 $d76T2281, D76T2282 $d76T2282)
    {
        $this->d76T1556 = $d76T1556;
        $this->d76T2300 = $d76T2300;
        $this->d76T2301 = $d76T2301;
        $this->d76T2280 = $d76T2280;
        $this->d76T2281 = $d76T2281;
        $this->d76T2282 = $d76T2282;
    }

    public function index($task = "", Request $request)
    {
        $title = Helpers::getRS("Ho_so_cong_viec_U");

        switch ($task) {
            case'':
                $userID = Auth::user()->UserID;
                $divisionID = session('W76P0000')->DivisionID;
                $orgUnitID = session('W76P0000')->OrgUnitID;
                $StrSearch = $request->input('txtSearchValueW84TaskList', '');
                $sql = '--Do nguon cho cong viec' . PHP_EOL;
                $sql .= "EXEC W84P1000 '$userID', '$divisionID', '$orgUnitID','$StrSearch'";
                $taskList = DB::select($sql);

                $priorityList = $this->d76T1556->select('CodeID', 'CodeName')->where('ListTypeID', "=", 'D84F1000_Priority')->get();
                ////\Debugbar::info($priorityList);

                $projectList = $this->d76T2300->select('ProjectID', 'ProjectName')->orderBy('ProjectName', 'desc')->get();
                ////\Debugbar::info($projectList);

                $stageList = $this->d76T2301->select('ProjectID', 'StageID', 'StageName')->orderBy('StageName', 'desc')->get();
                ////\Debugbar::info($stageList);

                $sql = '--Do nguon cho nguoi theo doi' . PHP_EOL;
                $sql .= "EXEC W76P9020 '$divisionID', 'EMP'";
                $empFollowList = DB::select($sql);
                foreach ($empFollowList as &$item) {
                    if ($item->Thumnail == "") {
                        $item->Thumnail = asset('media/available.png');
                    } else {
                        $item->Thumnail = 'data:image/jpeg;base64,' . base64_encode($item->Thumnail);
                    }
                }
                $rowData = (array)$taskList[0];
                $rowData['EmpFollow'] = explode(';', $rowData['EmpFollow']);

                return view("modules/W84/W84F1000/W84F1000", compact('title', 'rowData', 'empFollowList', 'stageList', 'projectList', 'priorityList', 'detail', 'taskList', 'task'));
                break;
            case'add':
                $userID = Auth::user()->UserID;
                $divisionID = session('W76P0000')->DivisionID;
                $orgUnitID = session('W76P0000')->OrgUnitID;
                $StrSearch = $request->input('txtSearchValueW84TaskList', '');

                $sql = '--Do nguon cho cong viec' . PHP_EOL;
                $sql .= "EXEC W84P1000 '$userID', '$divisionID', '$orgUnitID','$StrSearch'";
                $taskList = DB::select($sql);

                $priorityList = $this->d76T1556->select('CodeID', 'CodeName')->where('ListTypeID', "=", 'D84F1000_Priority')->get();
                ////\Debugbar::info($priorityList);

                $projectList = $this->d76T2300->select('ProjectID', 'ProjectName')->orderBy('ProjectName', 'desc')->get();
                ////\Debugbar::info($projectList);

                $stageList = $this->d76T2301->select('ProjectID', 'StageID', 'StageName')->orderBy('StageName', 'desc')->get();
                ////\Debugbar::info($stageList);

                $sql = '--Do nguon cho nguoi theo doi' . PHP_EOL;
                $sql .= "EXEC W76P9020 '$divisionID', 'EMP'";
                $empFollowList = DB::select($sql);
                foreach ($empFollowList as &$item) {
                    if ($item->Thumnail == "") {
                        $item->Thumnail = asset('media/available.png');
                    } else {
                        $item->Thumnail = 'data:image/jpeg;base64,' . base64_encode($item->Thumnail);
                    }
                }
                $rowData = json_encode(array());

                return view("modules/W84/W84F1000/W84F1000", compact('title', 'rowData', 'empFollowList', 'stageList', 'projectList', 'priorityList', 'detail', 'taskList', 'task'));
                break;
            case 'TaskList':
                $userID = Auth::user()->UserID;
                $divisionID = session('W76P0000')->DivisionID;
                $orgUnitID = session('W76P0000')->OrgUnitID;
                $StrSearch = $request->input('txtSearchValueW84TaskList', '');

                $sql = '--Do nguon cho cong viec' . PHP_EOL;
                $sql .= "EXEC W84P1000 '$userID', '$divisionID', '$orgUnitID','$StrSearch'";
                $taskList = DB::select($sql);

                $priorityList = $this->d76T1556->select('CodeID', 'CodeName')->where('ListTypeID', "=", 'D84F1000_Priority')->get();
                // //\Debugbar::info($priorityList);

                $projectList = $this->d76T2300->select('ProjectID', 'ProjectName')->orderBy('ProjectName', 'desc')->get();
                ////\Debugbar::info($projectList);

                $stageList = $this->d76T2301->select('ProjectID', 'StageID', 'StageName')->orderBy('StageName', 'desc')->get();
                ////\Debugbar::info($stageList);

                $sql = '--Do nguon cho nguoi theo doi' . PHP_EOL;
                $sql .= "EXEC W76P9020 '$divisionID', 'EMP'";
                $empFollowList = DB::select($sql);
                foreach ($empFollowList as &$item) {
                    if ($item->Thumnail == "") {
                        $item->Thumnail = asset('media/available.png');
                    } else {
                        $item->Thumnail = 'data:image/jpeg;base64,' . base64_encode($item->Thumnail);
                    }
                }
                $rowData = (array)$taskList[0];
                $rowData['EmpFollow'] = explode(';', $rowData['EmpFollow']);

                return view("modules/W84/W84F1000/W84F1000", compact('title', 'rowData', 'newsList', 'empFollowList', 'stageList', 'projectList', 'priorityList', 'detail', 'taskList', 'task'));
                break;
            case 'getdetail':
            case'edit':
                $TaskID = $request->input('TaskID', '');
                $userID = Auth::user()->UserID;
                $divisionID = session('W76P0000')->DivisionID;
                $orgUnitID = session('W76P0000')->OrgUnitID;
                $StrSearch = $request->input('txtSearchValueW84TaskList', '');

                $sql = '--Do nguon cho cong viec' . PHP_EOL;
                $sql .= "EXEC W84P1000 '$userID', '$divisionID', '$orgUnitID','$StrSearch'";
                $taskList = DB::select($sql);
                \Debugbar::info($taskList);

                $priorityList = $this->d76T1556->select('CodeID', 'CodeName')->where('ListTypeID', "=", 'D84F1000_Priority')->get();
                // //\Debugbar::info($priorityList);

                $projectList = $this->d76T2300->select('ProjectID', 'ProjectName')->orderBy('ProjectName', 'desc')->get();
                // //\Debugbar::info($projectList);

                $stageList = $this->d76T2301->select('ProjectID', 'StageID', 'StageName')->orderBy('StageName', 'desc')->get();
                ////\Debugbar::info($stageList);

                $sql = '--Do nguon cho nguoi theo doi' . PHP_EOL;
                $sql .= "EXEC W76P9020 '$divisionID', 'EMP'";
                $empFollowList = DB::select($sql);
                foreach ($empFollowList as &$item) {
                    if ($item->Thumnail == "") {
                        $item->Thumnail = asset('media/available.png');
                    } else {
                        $item->Thumnail = 'data:image/jpeg;base64,' . base64_encode($item->Thumnail);
                    }
                }
                $rowData = $this->getMaster($TaskID);

                $commentList = $this->getComment($TaskID);
                //var_dump($commentList);die();

                return view("modules/W84/W84F1000/W84F1000", compact('title', 'commentList', 'rowData', 'empFollowList', 'stageList', 'projectList', 'priorityList', 'detail', 'taskList', 'task'));
                break;
            case'save':
                try {
                    //$TaskID = $request->input('TaskID', '');
                    $taskNameW84F1000 = \Helpers::sqlstring($request->input('taskNameW84F1000', ''));
                    $employeeW84F1000 = \Helpers::sqlstring($request->input('employeeW84F1000', ''));
                    $priorityW84F1001 = \Helpers::sqlstring($request->input('priorityW84F1001', ''));
                    $projectIDW84F1001 = \Helpers::sqlstring($request->input('projectIDW84F1001', ''));
                    $projectStageW84F1001 = \Helpers::sqlstring($request->input('projectStageW84F1001', ''));
                    $startDateW84F1001 = \Helpers::createDateTime($request->input('startDateW84F1001', ''));
                    $deadlineW84F1001 = \Helpers::createDateTime($request->input('deadlineW84F1001', ''));
                    $empFollowW84F1001 = $request->input('empFollowW84F1001', []);

                    $descriptionW84F1001 = \Helpers::sqlstring($request->input('descriptionW84F1001', ''));
                    $userID = Auth::user()->UserID;
                    $dateNow = Carbon::now();
                    //save master
                    $data = [
                        //"TaskID" => $TaskID,
                        "TaskName" => $taskNameW84F1000,
                        "ProjectID" => $projectIDW84F1001,
                        "ProjectStage" => $projectStageW84F1001,
                        "EmployeeID" => $employeeW84F1000,
                        "EmpFollow" => implode(';', $empFollowW84F1001),

                        "Priority" => $priorityW84F1001,
                        "StartDate" => $startDateW84F1001,
                        "Deadline" => $deadlineW84F1001,
                        "Remark" => $descriptionW84F1001,
                        "CreateDate" => $dateNow,
                        "CreateUserID" => $userID,
                    ];
                    $TaskID = $this->d76T2280->insertGetId($data);
                    foreach ($empFollowW84F1001 as $empFollow) {
                        $this->d76T2281->insert([
                            'TaskID' => $TaskID,
                            'EmpFollowID' => $empFollow,
                            'CreateDate' => $dateNow,
                            'CreateUserID' => $userID
                        ]);
                    }
                    \Helpers::setSession('successMessage', \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong'));
//                    \Helpers::setSession('lastNewsModified', $newsID);
                    return json_encode(['status' => 'SUCC', 'message' => \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong')]);
                } catch (\Exception $ex) {
                    \Helpers::log($ex->getMessage());
                    return json_encode(['status' => 'ERROR', 'message' => $ex->getMessage()]);
                }
                break;
            case 'update':
                try {
                    $TaskID = $request->input('TaskID', '');
                    $taskNameW84F1000 = \Helpers::sqlstring($request->input('taskNameW84F1000', ''));
                    $employeeW84F1000 = \Helpers::sqlstring($request->input('employeeW84F1000', ''));
                    $priorityW84F1001 = \Helpers::sqlstring($request->input('priorityW84F1001', ''));
                    $projectIDW84F1001 = \Helpers::sqlstring($request->input('projectIDW84F1001', ''));
                    $projectStageW84F1001 = \Helpers::sqlstring($request->input('projectStageW84F1001', ''));
                    $startDateW84F1001 = \Helpers::createDateTime($request->input('startDateW84F1001', ''));
                    $deadlineW84F1001 = \Helpers::createDateTime($request->input('deadlineW84F1001', ''));
                    $empFollowW84F1001 = $request->input('empFollowW84F1001', []);
                    $descriptionW84F1001 = \Helpers::sqlstring($request->input('descriptionW84F1001', ''));
                    $lastModifyDateW84F1001 = Carbon::now();
                    $lastModifyUserIDW84F1001 = Auth::user()->UserID;

                    $data = [
                        //"TaskID" => $TaskID,
                        "TaskName" => $taskNameW84F1000,
                        "ProjectID" => $projectIDW84F1001,
                        "ProjectStage" => $projectStageW84F1001,
                        "EmployeeID" => $employeeW84F1000,
                        "EmpFollow" => implode(';', $empFollowW84F1001),
                        "Priority" => $priorityW84F1001,
                        "StartDate" => $startDateW84F1001,
                        "Deadline" => $deadlineW84F1001,
                        "Remark" => $descriptionW84F1001,
                        "LastModifyDate" => $lastModifyDateW84F1001,
                        "LastModifyUserID" => $lastModifyUserIDW84F1001,
                    ];
                    $this->d76T2280->where('TaskID', '=', $TaskID)->update($data);
                    \Helpers::setSession('successMessage', \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong'));
                    return json_encode(['status' => 'SUCC', 'message' => \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong')]);
                } catch (\Exception $ex) {
                    \Helpers::log($ex->getMessage());
                    return json_encode(['status' => 'ERROR', 'message' => $ex->getMessage()]);
                }
                break;
            case 'delete':
                $divisionID = session('W76P0000')->DivisionID;
                $orgUnitID = session('W76P0000')->OrgUnitID;
                $lang = \Helpers::getLang();
                $userID = Auth::user()->UserID;
                $Mode = "D";
                $FormID = "W84F1000";
                $TaskID = $request->input('TaskID', '');
                $Key01ID = "";
                $Key02ID = "";
                $Key03ID = "";
                $Key04ID = "";
                $Key05ID = "";
                $codeTable = 1;
//                $Dat01 = \Helpers::convertDate('');
//                $Dat02 = \Helpers::convertDate('');
//                $Dat03 = \Helpers::convertDate('');
//                $Dat04 = \Helpers::convertDate('');
//                $Dat05 = \Helpers::convertDate('');

                $sql = "--Kiem tra truoc khi xoa" . PHP_EOL;
                $sql .= "EXEC W76P5555 " . PHP_EOL;
                $sql .= "'$divisionID'," . PHP_EOL; //DivisionID, varchar[50], NOT NULL
                $sql .= "'$lang'," . PHP_EOL; //Lang, int, NOT NULL
                $sql .= "$codeTable," . PHP_EOL; //CodeTable, tinyint, NOT NULL
                $sql .= "'$userID'," . PHP_EOL; //TranYear, int, NOT NULL
                $sql .= "'$Mode'," . PHP_EOL; //Language, varchar[2], NOT NULL
                $sql .= "'$FormID'," . PHP_EOL; //Language, varchar[2], NOT NULL
                $sql .= "'$TaskID'," . PHP_EOL; //UserID, varchar[50], NOT NULL
                $sql .= "N'$Key01ID'," . PHP_EOL; //Key01ID, nvarchar, NOT NULL
                $sql .= "N'$Key02ID'," . PHP_EOL; //Key02ID, nvarchar, NOT NULL
                $sql .= "N'$Key03ID'," . PHP_EOL; //Key03ID, nvarchar, NOT NULL
                $sql .= "N'$Key04ID'," . PHP_EOL; //Key04ID, nvarchar, NOT NULL
                $sql .= "N'$Key05ID'," . PHP_EOL; //Key05ID, nvarchar, NOT NULL
                $sql .= "0," . PHP_EOL; //Num01, decimal, NOT NULL
                $sql .= "0," . PHP_EOL; //Num02, decimal, NOT NULL
                $sql .= "0," . PHP_EOL; //Num03, decimal, NOT NULL
                $sql .= "0," . PHP_EOL; //Num04, decimal, NOT NULL
                $sql .= "0," . PHP_EOL; //Num05, decimal, NOT NULL
                $sql .= "NULL," . PHP_EOL; //Dat01, datetime, NOT NULL
                $sql .= "NULL," . PHP_EOL; //Dat02, datetime, NOT NULL
                $sql .= "NULL," . PHP_EOL; //Dat03, datetime, NOT NULL
                $sql .= "NULL," . PHP_EOL; //Dat04, datetime, NOT NULL
                $sql .= "NULL"; //Dat04, datetime, NOT NULL

                $rsCheck = DB::selectOne($sql);
                //\Debugbar::info($rsCheck);
                if ($rsCheck->Status == 0) {
                    $sql = "--Xoa quan ly cong viec" . PHP_EOL;
                    $sql .= "EXEC W84P1002 '$userID','$orgUnitID','$divisionID','$TaskID'" . PHP_EOL;
                    try {
                        DB::connection()->statement($sql);
                        return json_encode(['status' => 'SUCC', 'name' => '', "message" => Helpers::getRS("Du_lieu_da_duoc_xoa_thanh_cong")]);
                    } catch (Exception $ex) {
                        return json_encode(['status' => 'ERROR', 'name' => '', "message" => Helpers::getRS("Co_loi_xay_ra_trong_qua_trinh_xu_ly_du_lieu")]);
                    }
                } else {
                    return json_encode(['status' => 'ERROR', 'name' => '', "message" => $rsCheck[0]['Message']]);
                }
                break;

            case 'update_comment':
                try {
                    $TaskID = $request->input('TaskID', '');
//                var_dump($TaskID);die();
                    $txtCommentW84F1000 = \Helpers::sqlstring($request->input('comments', ''));
                    $userID = Auth::user()->UserID;
                    $dateNow = Carbon::now();
                    $data = [
                        "TaskID" => $TaskID,
                        "Comment" => $txtCommentW84F1000,
                        "CreateDate" => $dateNow,
                        "CreateUserID" => $userID,
                    ];
                    $this->d76T2282->where('TaskID', $TaskID)->insert($data);
                    return json_encode(['status' => 'SUCC', 'name' => '', "message" => Helpers::getRS("Du_lieu_da_duoc_xoa_thanh_cong")]);
                } catch (Exception $ex) {
                    return json_encode(['status' => 'ERROR', 'name' => '', "message" => Helpers::getRS("Co_loi_xay_ra_trong_qua_trinh_xu_ly_du_lieu")]);
                }
                break;
            case'process':
                $TaskID = $request->input('TaskID', '');
                \Debugbar::info($TaskID);
                $statusList = $this->d76T1556->select('CodeID', 'CodeName')->where('ListTypeID', "=", 'D84F1000_StatusID')->get();
                $rowData = $this->getMaster($TaskID);

                return view("modules/W84/W84F1000/UpdateProcess", compact('rowData', 'statusList', 'task'));
                break;
            case 'update_Process':
                try {
                    $TaskID = $request->input('TaskID', '');
                    //\Debugbar::info($TaskID);
                    $statusID_UpdateProcess = \Helpers::sqlstring($request->input('statusID_UpdateProcess', ''));
                    $percentComplete = \Helpers::sqlstring($request->input('percentComplete', ''));
                    $manHours_UpdateProcess = \Helpers::sqlstring($request->input('manHours_UpdateProcess', ''));
                    $resultContent_UpdateProcess = \Helpers::sqlstring($request->input('resultContent_UpdateProcess', ''));
                    $lastModifyDateW84F1001 = Carbon::now();
                    $lastModifyUserIDW84F1001 = Auth::user()->UserID;
                    $data = [
                        //"TaskID" => $TaskID,
                        "StatusID" => $statusID_UpdateProcess,
                        "PercentComplete" => $percentComplete,
                        "ManHours" => $manHours_UpdateProcess,
                        "ResultContent" => $resultContent_UpdateProcess,
                        "LastModifyDate" => $lastModifyDateW84F1001,
                        "LastModifyUserID" => $lastModifyUserIDW84F1001,
                    ];
                    //\Debugbar::info($data);
                    $this->d76T2280->where('TaskID', '=', $TaskID)->update($data);

                    \Helpers::setSession('successMessage', \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong'));
                    return json_encode(['status' => 'SUCC', 'message' => \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong')]);
                } catch (\Exception $ex) {
                    return json_encode(['status' => 'ERROR', 'message' => $ex->getMessage()]);
                }
                break;
            case 'AssignTask':
                $TaskID = $request->input('TaskID', '');
                $divisionID = session('W76P0000')->DivisionID;
                $sql = '--Do nguon cho nguoi xu ly' . PHP_EOL;
                $sql .= "EXEC W76P9020 '$divisionID', 'EMP'";
                $emPloyeeList = DB::select($sql);
                foreach ($emPloyeeList as &$item) {
                    if ($item->Thumnail == "") {
                        $item->Thumnail = asset('media/available.png');
                    } else {
                        $item->Thumnail = 'data:image/jpeg;base64,' . base64_encode($item->Thumnail);
                    }
                }
                $rowData = $this->getMaster($TaskID);
                return view("modules/W84/W84F1000/AssignTask", compact('rowData', 'emPloyeeList', 'task'));
                break;
            case 'update_AssignTask':
                try {
                    $TaskID = $request->input('TaskID', '');
                    $employee_AssignTask = \Helpers::sqlstring($request->input('employee_AssignTask', ''));
                    $lastModifyDateW84F1001 = Carbon::now();
                    $lastModifyUserIDW84F1001 = Auth::user()->UserID;

                    $data = [
                        "EmployeeID" => $employee_AssignTask,
                        "LastModifyDate" => $lastModifyDateW84F1001,
                        "LastModifyUserID" => $lastModifyUserIDW84F1001,
                    ];
                    $this->d76T2280->where('TaskID', '=', $TaskID)->update($data);

                    \Helpers::setSession('successMessage', \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong'));
                    return json_encode(['status' => 'SUCC', 'message' => \Helpers::getRS('Du_lieu_da_duoc_luu_thanh_cong')]);
                } catch
                (\Exception $ex) {
                    return json_encode(['status' => 'ERROR', 'message' => $ex->getMessage()]);
                }
                break;
            case 'update_like':
                try {
                    $CommentID = $request->input('CommentID', '');
                    $status = $request->input('status', ''); //1: like, 0: unlike
                    $userID = Auth::user()->UserID;
                    $comment = $this->d76T2282->where('CommentID', $CommentID)->select('CountLike')->first();
                    $count = 0;
                    if ($status == 1) {
                        $count = $comment->CountLike + 1;
                    } else {
                        $count = $comment->CountLike - 1;
                    }
                    $this->d76T2282->where("CommentID", $CommentID)->update([
                        "CountLike" => $count
                    ]);

                    return json_encode(['count' => $count]);
                } catch (\Exception $ex) {
                    return json_encode(['status' => 'ERROR', 'message' => $ex->getMessage()]);
                }


                break;
        }
    }

    function getMaster($TaskID)
    {
        $result = $this->d76T2280->where("TaskID", "=", $TaskID)->first();
        $result->EmpFollow = explode(';', $result->EmpFollow);
        //var_dump($result);die();
        //\Debugbar::info("tesst", $result);
        return $result;
    }

    function getComment($TaskID)
    {
        $userID = Auth::user()->UserID;
        $divisionID = session('W76P0000')->DivisionID;
        $orgUnitID = session('W76P0000')->OrgUnitID;

        $sql = '--Do nguon cho binh luan' . PHP_EOL;
        $sql .= "EXEC W84P1003 '$userID', '$divisionID','$orgUnitID','$TaskID' ";
        $commentList = DB::select($sql);
        foreach ($commentList as &$item) {
            if ($item->Thumnail == "") {
                $item->Thumnail = asset('media/available.png');
            } else {
                $item->Thumnail = 'data:image/jpeg;base64,' . base64_encode($item->Thumnail);
            }
        }
        \Debugbar::info($commentList);

        return $commentList;
    }
}
