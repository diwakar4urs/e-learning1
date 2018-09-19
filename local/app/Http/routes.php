<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
 
    if(Auth::check())
    {
        return redirect('dashboard');
    }
    
    return redirect(URL_USERS_LOGIN);
});


if(env('DB_DATABASE')=='')
{

   Route::get('/', 'InstallatationController@index');

   Route::get('/install', 'InstallatationController@index');
   Route::post('/update-details', 'InstallatationController@updateDetails');
   Route::post('/install', 'InstallatationController@installProject');
}


if(env('DEMO_MODE')) {
    Event::listen('eloquent.saving: *', function ($model) {
      return false;
    });
    Event::listen('eloquent.deleting: *', function ($model) {
      return false;
    });
     
}

 // Route::get('install/reg', 'InstallatationController@reg');
 Route::post('install/register', 'InstallatationController@registerUser');
 



Route::get('dashboard','DashboardController@index');
Route::get('dashboard/testlang','DashboardController@testLanguage');


Route::get('auth/{slug}','Auth\AuthController@redirectToProvider');
Route::get('auth/{slug}/callback','Auth\AuthController@handleProviderCallback');



// Authentication Routes...
 Route::get('login', 'Auth\AuthController@getLogin');


// Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');

Route::get('logout', function(){

	if(Auth::check())
		flash(getPhrase('success'),getPhrase('logged_out_successfully'),'success');

	Auth::logout();
	return redirect(URL_USERS_LOGIN);
});

Route::get('parent-logout', function(){
    if(Auth::check())
        flash('Oops..!',getPhrase('parents_module_is_not_available'),'error');
    Auth::logout();
    return redirect(URL_USERS_LOGIN);
});


// Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration Routes...
// Route::get('register', 'Auth\AuthController@getRegister');
// Route::post('register', 'Auth\AuthController@postRegister');

// Forgot Password Routes...
// Route::get('forgot-password', 'PasswordController@postEmail');
Route::post('users/forgot-password', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{slug?}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::get('languages/list', 'NativeController@index');
Route::get('languages/getList', [ 'as'   => 'languages.dataTable',
     'uses' => 'NativeController@getDatatable']);
 
Route::get('languages/add', 'NativeController@create');
Route::post('languages/add', 'NativeController@store');
Route::get('languages/edit/{slug}', 'NativeController@edit');
Route::patch('languages/edit/{slug}', 'NativeController@update');
Route::delete('languages/delete/{slug}', 'NativeController@delete');
 
Route::get('languages/make-default/{slug}', 'NativeController@changeDefaultLanguage');
Route::get('languages/update-strings/{slug}', 'NativeController@updateLanguageStrings');
Route::patch('languages/update-strings/{slug}', 'NativeController@saveLanguageStrings');


//Departments
Route::get('departments', 'DepartmentsController@index');
Route::get('departments/add-department', 'DepartmentsController@createDepartment');
Route::post('departments/add-department', 'DepartmentsController@storeDepartment');
Route::get('departments/edit-department/{slug}', 'DepartmentsController@editDepartment');
Route::patch('departments/edit-department/{slug}', 'DepartmentsController@updateDepartment');
Route::delete('departments/delete/{id}', 'DepartmentsController@delete');
Route::get('departments/getDepartments', [ 'as'   => 'departments.dataTable',
    'uses' => 'DepartmentsController@getDatatable']);


//Users
//Users ---dashboard
Route::get('users/dashboard', 'UsersDashboardController@index');
Route::get('users/import','UsersController@importUsers');
Route::post('users/import','UsersController@readExcel');

Route::get('users/create', 'UsersController@create');
Route::get('users/staff-inactive/{role}', 'UsersController@staff_inactivelist');
Route::delete('users/delete/{slug}', 'UsersController@delete');
Route::post('users/create/{role?}', 'UsersController@store');
Route::get('users/edit/{slug}', 'UsersController@edit');
Route::patch('users/edit/{slug}', 'UsersController@update');
Route::get('users/profile/{slug}', 'UsersController@show');
Route::get('users/{users?}', 'UsersController@index');
Route::get('users/profile/{slug}', 'UsersController@show');
Route::get('users/details/{slug}', 'UsersController@details');
Route::post('users/change-status', 'UsersController@changeStatus');
Route::get('users/details/promotions/{slug}', 'UsersController@transfers');
Route::get('users/details/library/{slug}', 'UsersController@student_librarydetails');
Route::get('users/details/library/get-list/{id}', 'UsersController@getlibraryhistory');
Route::get('staff/details/{slug}', 'UsersController@staffDetails');

Route::get('users/settings/{slug}', 'UsersController@settings');
Route::patch('users/settings/{slug}', 'UsersController@updateSettings');

Route::get('users/change-password/{slug}', 'UsersController@changePassword');
Route::patch('users/change-password/{slug}', 'UsersController@updatePassword');

Route::get('users/import','UsersController@importUsers');
Route::post('users/import','UsersController@readExcel');

Route::get('users/import-report','UsersController@importResult');
Route::get('users/{role?}', 'UsersController@index');

Route::post('users/import/get-excel-information', 'UsersController@getExcelUploadInformation');


Route::get('users/list/getList/{role_name?}', [ 'as'   => 'users.dataTable',
    'uses' => 'UsersController@getDatatable']);

Route::get('users/staff-inactive/getList/{slug}', [ 'as'   => 'users-staff_inactive.dataTable',
    'uses' => 'UsersController@getStaffInactiveList']);
// Route::get('users/list/getList/{role_name?}', 'UsersController@getDatatable');


//Staff
Route::patch('staff/profile/edit/general/{id}','StaffController@updateGeneralDetails');
Route::patch('staff/profile/edit/personal/{id}','StaffController@updatePersonalDetails');
Route::patch('staff/profile/edit/contact/{id}','StaffController@updateContactDetails');
Route::get('staff/profile/edit/{slug}/{tab?}', 'StaffController@edit');
Route::post('staff/profile/edit/status', 'StaffController@editstatus');
Route::get('staff/profile/{slug}', 'StaffController@show');

//Staff subject preference
Route::get('staff/subjects/preferences/{slug}','SubjectPreferencesController@subjectPreferences');
Route::post('staff/subjects/preferences/{slug}','SubjectPreferencesController@update');

            //////////////////////
            //Parent Controller //
            //////////////////////
Route::get('parent/children', 'ParentsController@index');
Route::get('parent/children/list', 'ParentsController@index');
Route::get('parent/children/getList/{slug}', 'ParentsController@getDatatable');
Route::get('children/analysis', 'ParentsController@childrenAnalysis');
   
                    /////////////////////
                    // Master Settings //
                    /////////////////////
 
//Religions
Route::get('mastersettings/religions', 'ReligionsController@index');
Route::get('mastersettings/religions/add', 'ReligionsController@create');
Route::post('mastersettings/religions/add', 'ReligionsController@store');
Route::get('mastersettings/religions/edit/{slug}', 'ReligionsController@edit');
Route::patch('mastersettings/religions/edit/{slug}', 'ReligionsController@update');
Route::delete('mastersettings/religions/delete/{id}', 'ReligionsController@delete');
Route::get('mastersettings/religions/getList', [ 'as'   => 'religions.dataTable',
    'uses' => 'ReligionsController@getDatatable']);


//Categories
Route::get('mastersettings/categories', 'CategoriesController@index');
Route::get('mastersettings/categories/add', 'CategoriesController@create');
Route::post('mastersettings/categories/add', 'CategoriesController@store');
Route::get('mastersettings/categories/edit/{slug}', 'CategoriesController@edit');
Route::patch('mastersettings/categories/edit/{slug}', 'CategoriesController@update');
Route::delete('mastersettings/categories/delete/{id}', 'CategoriesController@delete');
Route::get('mastersettings/categories/getList', [ 'as'   => 'categories.dataTable',
    'uses' => 'CategoriesController@getDatatable']);


//Academics
Route::get('mastersettings/academics', 'AcademicsController@index');
Route::get('mastersettings/academics/add', 'AcademicsController@create');
Route::post('mastersettings/academics/add', 'AcademicsController@store');
Route::get('mastersettings/academics/edit/{slug}', 'AcademicsController@edit');
Route::patch('mastersettings/academics/edit/{slug}', 'AcademicsController@update');
Route::delete('mastersettings/academics/delete/{id}', 'AcademicsController@delete');
Route::get('mastersettings/academics/getList', [ 'as'   => 'academics.dataTable',
    'uses' => 'AcademicsController@getDatatable']);
Route::get('mastersettings/academics/get-academics', 'AcademicsController@getAcademics');


//Academic Courses
Route::post('mastersettings/academic-courses/check-status', 'AcademicCoursesController@checkStatus');

Route::get('mastersettings/academic-courses/{slug}', 'AcademicCoursesController@academicCoursesArrangment');
Route::post('mastersettings/academic-courses/{slug}', 'AcademicCoursesController@updateAcademicCourses');


Route::post('academic-courses/get-parent-courses', 'AcademicCoursesController@getParentCourses');
Route::post('academic-courses/get-child-courses', 'AcademicCoursesController@getChildCourses');



//courses

//Courese ---dashboard
Route::get('courses/dashboard', 'CourseController@coursesdashboard');
Route::get('mastersettings/course', 'CourseController@index');
Route::get('mastersettings/course/add', 'CourseController@create');
Route::post('mastersettings/course/add', 'CourseController@store');
Route::get('mastersettings/course/edit/{slug}', 'CourseController@edit');
Route::patch('mastersettings/course/edit/{slug}', 'CourseController@update');
Route::delete('mastersettings/course/delete/{id}', 'CourseController@delete');
Route::get('mastersettings/course/getList', [ 'as'   => 'course.dataTable',
    'uses' => 'CourseController@getDatatable']);

Route::get('mastersettings/course/editSemisters/{slug}', 'CourseController@editSemisters');
Route::patch('mastersettings/course/editSemisters', 'CourseController@updateSemisters');


//Course Subjects 
Route::get('mastersettings/course-subjects/add', 'CourseSubjectsController@create');

Route::post('mastersettings/course-subjects/add', 'CourseSubjectsController@store');
Route::patch('mastersettings/course-subjectsd/edit/{slug}', 'CourseSubjectsController@update');
Route::delete('mastersettings/course-subjects/delete', 'CourseSubjectsController@delete');
Route::get('mastersettings/course-subjects/getList/{slug}', 'CourseSubjectsController@getDatatable');
Route::get('mastersettings/course-subjects/{slug?}', 'CourseSubjectsController@index');

Route::post('mastersettings/course-subjects/getCourseYears', 'CourseSubjectsController@getCourseYears');
Route::post('mastersettings/course-subjects/getSemisters', 'CourseSubjectsController@getSemisters');
Route::post('mastersettings/course-subjects/getSavedSubjects', 'CourseSubjectsController@getSavedSubjects');
Route::get('mastersettings/course-subjects/show/{academic_id}/{course_id}', 'CourseSubjectsController@show');
Route::post('academic-courses/remove-subject', 'CourseSubjectsController@removeSubject');

Route::get('subjects/view-topics/{subject_slug}', 'SubjectsController@viewTopics');

Route::post('mastersettings/course-subjects/load', 'CourseSubjectsController@loadYearDetails');
Route::get('mastersettings/course-subjects/load', 'CourseSubjectsController@create');

Route::get('course-subjects/add-staff/{academic_id}/{course_id}', 'CourseSubjectsController@staffAllotment');
Route::post('course-subjects/update-staff', 'CourseSubjectsController@updateStaffAllotment');
Route::post('course-subjects/is-staff-allocated', 'CourseSubjectsController@isSatffAllocatedToTimetable');

//Certificate Templates
Route::get('mastersettings/certificate_templates', 'CertificateTemplatesController@index');
Route::get('mastersettings/certificate_templates/add', 'CertificateTemplatesController@create');
Route::post('mastersettings/certificate_templates/add', 'CertificateTemplatesController@store');
Route::get('mastersettings/certificate_templates/edit/{slug}', 'CertificateTemplatesController@edit');
Route::patch('mastersettings/certificate_templates/edit/{slug}', 'CertificateTemplatesController@update');
Route::delete('mastersettings/certificate_templates/delete/{id}', 'CertificateTemplatesController@delete');
Route::get('mastersettings/certificate_templates/getList', [ 'as'   => 'certificate_templates.dataTable',
    'uses' => 'CertificateTemplatesController@getDatatable']);

//Certificate Generation links

Route::get('certificates/dashboard', 'CertificatesController@certificatesDashboard');
Route::get('certificates/id-cards', 'CertificatesController@idCards');
Route::post('students/get-users', 'StudentController@getStudents');
Route::post('students/get-users/completed', 'StudentController@getCompletedStudents');
Route::post('students/get-users/detained', 'StudentController@getDetainedStudents');
Route::get('certificates/bonafide-certificates', 
    'CertificatesController@bonafideCertificates');

Route::post('certificates/id-cards', 'CertificatesController@printCards');

Route::post('certificate-issues/is-issued', 'CertificatesIssuesController@isIssued');
Route::post('certificate/issue', 'CertificatesIssuesController@issueCertificate');
Route::post('certificate/issue/tc', 'CertificatesIssuesController@tcDetails');


//Academic Holidays
Route::get('mastersettings/holidays', 'AcademicHolidaysController@index');
Route::get('mastersettings/holidays/add', 'AcademicHolidaysController@create');
Route::post('mastersettings/holidays/add', 'AcademicHolidaysController@store');
Route::get('mastersettings/holidays/edit/{slug}', 'AcademicHolidaysController@edit');
Route::patch('mastersettings/holidays/edit/{slug}', 'AcademicHolidaysController@update');
Route::delete('mastersettings/holidays/delete/{id}', 'AcademicHolidaysController@delete');
Route::get('mastersettings/holidays/getList', [ 'as'   => 'academicholidays.dataTable',
    'uses' => 'AcademicHolidaysController@getDatatable']);

//Student
Route::get('student/profile/edit/{slug}/{tab?}', 'StudentController@edit');
Route::patch('student/profile/edit/general/{slug}','StudentController@updateGeneralDetails');
Route::patch('student/profile/edit/personal/{slug}','StudentController@updatePersonalDetails');
Route::patch('student/profile/edit/contact/{slug}','StudentController@updateContactDetails');
Route::patch('student/profile/edit/parent/{slug}','StudentController@updateParentDetails');
Route::get('student/profile/{slug}', 'StudentController@show');
Route::post('student/get-parent-records', 'StudentController@getParentsOnSearch');

Route::post('student/courses', 'StudentController@courses');

Route::get('student/course-semister/{courseId}/{semisterId}', 'StudentController@coursesSemister');

 

//subjects
Route::get('mastersettings/subjects', 'SubjectsController@index');
Route::get('mastersettings/subjects/add', 'SubjectsController@create');
Route::post('mastersettings/subjects/add', 'SubjectsController@store');
Route::get('mastersettings/subjects/edit/{slug}', 'SubjectsController@edit');
Route::patch('mastersettings/subjects/edit/{slug}', 'SubjectsController@update');
Route::delete('mastersettings/subjects/delete/{id}', 'SubjectsController@delete');
Route::get('mastersettings/subjects/getList', [ 'as'   => 'subjects.dataTable',
    'uses' => 'SubjectsController@getDatatable']);

Route::get('mastersettings/subjects/import', 'SubjectsController@import');
Route::post('mastersettings/subjects/import', 'SubjectsController@readExcel');
 
//Topics 
Route::get('mastersettings/topics', 'TopicsController@index');
Route::get('mastersettings/topics/add', 'TopicsController@create');
Route::post('mastersettings/topics/add', 'TopicsController@store');
Route::get('mastersettings/topics/edit/{slug}', 'TopicsController@edit');
Route::patch('mastersettings/topics/edit/{slug}', 'TopicsController@update');
Route::delete('mastersettings/topics/delete/{id}', 'TopicsController@delete');
Route::get('mastersettings/topics/getList', [ 'as'   => 'topics.dataTable',
    'uses' => 'TopicsController@getDatatable']);

Route::get('mastersettings/topics/get-parents-topics/{subject_id}', 'TopicsController@getParentTopics');

Route::get('mastersettings/topics/import', 'TopicsController@import');
Route::post('mastersettings/topics/import', 'TopicsController@readExcel');


//Users
Route::get('users/staff/{role?}', 'UsersController@index');
Route::get('users/create', 'UsersController@create');
Route::post('users/create/{role?}', 'UsersController@store');
Route::get('users/edit/{slug}', 'UsersController@edit');
Route::patch('users/edit/{slug}', 'UsersController@update');
Route::get('users/profile/{slug}', 'UsersController@show');
Route::get('users', 'UsersController@index');

Route::get('users/list/{user_type}', 'UsersController@listUsers');

                     ///////////////////////////////
                    // LIBRARY MANAGEMENT SYSTEM //
                    ///////////////////////////////

//Library dashboard
Route::get('library/librarydashboard', 'LibraryDashboardController@index');
Route::get('library/librarydashboard/books', 'LibraryDashboardController@books');
Route::get('library/librarydashboard/books/staffbooks', 'LibraryDashboardController@staffbooks');

Route::get('library/librarydashboard/getList', 
      ['as'  =>'librarydashboard.datatable',
      'uses' =>'LibraryDashboardController@getDatatable']);

Route::get('library/librarydashboard/getList/staff', 
    ['as'  =>'librarydashboard.staffdatatable',
    'uses' =>'LibraryDashboardController@getStaffDatatable']);




//Library Assets
Route::get('library/assets', 'LibraryAssetTypeController@index');
Route::get('library/assets/add', 'LibraryAssetTypeController@create');
Route::get('library/assets/view/{slug}', 'LibraryAssetTypeController@show');

Route::post('library/assets/add', 'LibraryAssetTypeController@store');
Route::get('library/assets/edit/{slug}', 'LibraryAssetTypeController@edit');
Route::patch('library/assets/edit/{slug}', 'LibraryAssetTypeController@update');
Route::delete('library/assets/delete/{id}', 'LibraryAssetTypeController@delete');
Route::get('library/assets/getList', [ 'as'   => 'libraryassets.dataTable',
    'uses' => 'LibraryAssetTypeController@getDatatable']);


//Library Masters
Route::get('library/master', 'LibraryMastersController@index');
Route::get('library/master/add', 'LibraryMastersController@create');
Route::get('library/master/view/{slug}', 'LibraryMastersController@show');
Route::get('library/master/details/{slug}', 'LibraryMastersController@master_assetDetails');
Route::get('library/master/details/print/{slug}', 'LibraryMastersController@printMasterAssetDetails');

Route::post('library/master/add', 'LibraryMastersController@store');
Route::get('library/master/edit/{slug}', 'LibraryMastersController@edit');
Route::patch('library/master/edit/{slug}', 'LibraryMastersController@update');
Route::delete('library/master/delete/{id}', 'LibraryMastersController@delete');
Route::get('library/master/getList', [ 'as'   => 'librarymasters.dataTable',
    'uses' => 'LibraryMastersController@getDatatable']);

//Library Collections
Route::get('library/master/collections/{slug}', 'LibraryMastersController@viewCollections');
Route::get('library/master/get-collection-list/{slug}', 'LibraryMastersController@getInstanceDatatable');
Route::get('library/master/collections/add/{slug}', 'LibraryMastersController@addCollection');
Route::post('library/master/collections/add/{slug}', 'LibraryMastersController@storeCollection');
Route::post('library/master/change-status', 'LibraryMastersController@statusChange');
Route::get('library/master/collections/barcode/{asset_no}', 'LibraryMastersController@generateBarCode');
Route::delete('library/master/collections/delete/{id}', 'LibraryMastersController@deleteRecord');


//Authors
Route::get('library/authors', 'AuthorsController@index');
Route::get('library/authors/add', 'AuthorsController@create');
Route::get('library/authors/view/{slug}', 'AuthorsController@show');
Route::post('library/authors/add', 'AuthorsController@store');
Route::get('library/authors/edit/{slug}', 'AuthorsController@edit');
Route::patch('library/authors/edit/{slug}', 'AuthorsController@update');
Route::delete('library/authors/delete/{id}', 'AuthorsController@delete');
Route::get('library/authors/getList', [ 'as'   => 'authors.dataTable',
    'uses' => 'AuthorsController@getDatatable']);

//Authors
Route::get('library/publishers', 'PublishersController@index');
Route::get('library/publishers/add', 'PublishersController@create');
Route::get('library/publishers/view/{slug}', 'PublishersController@show');
Route::post('library/publishers/add', 'PublishersController@store');
Route::get('library/publishers/edit/{slug}', 'PublishersController@edit');
Route::patch('library/publishers/edit/{slug}', 'PublishersController@update');
Route::delete('library/publishers/delete/{id}', 'PublishersController@delete');
Route::get('library/publishers/getList', [ 'as'   => 'publishers.dataTable',
    'uses' => 'PublishersController@getDatatable']);



//Asset Issues
Route::get('library/users/{role_name}', 'LibraryIssuesController@users');
Route::get('library/getUsersList/{role_name}', 'LibraryIssuesController@getUsers');
Route::get('library/issue/{slug}', 'LibraryIssuesController@issueAsset');
Route::get('library/issues/get-reference', 'LibraryIssuesController@getReference');
Route::get('library/issues/get-reference/staff', 'LibraryIssuesController@getstaffReference');
Route::post('library/issues/get-master-details', 'LibraryIssuesController@getMasterDetails');
Route::post('library/issues/issue-asset', 'LibraryIssuesController@store');
Route::post('library/returns/return-asset', 'LibraryIssuesController@returnAsset');
Route::post('library/returns/return-asset/staff', 'LibraryIssuesController@returnStaffAsset');




                    ////////////////////////
                    // EXAMINATION SYSTEM //
                    ////////////////////////

//Question bank
Route::get('exams/questionbank', 'QuestionBankController@index');
Route::get('exams/questionbank/add-question/{slug}', 'QuestionBankController@create');
Route::get('exams/questionbank/view/{slug}', 'QuestionBankController@show');

Route::post('exams/questionbank/add', 'QuestionBankController@store');
Route::get('exams/questionbank/edit-question/{slug}', 'QuestionBankController@edit');
Route::patch('exams/questionbank/edit/{slug}', 'QuestionBankController@update');
Route::delete('exams/questionbank/delete/{id}', 'QuestionBankController@delete');
Route::get('exams/questionbank/getList',  'QuestionBankController@getDatatable');

Route::get('exams/questionbank/getquestionslist/{slug}', 
     'QuestionBankController@getQuestions');
Route::get('exams/questionbank/import',  'QuestionBankController@import');
Route::post('exams/questionbank/import',  'QuestionBankController@readExcel');
Route::get('exams/questionbank/delete/option-file/{id}/{imagename}', 'QuestionBankController@deleteOptionFile');
Route::post('exams/questionbank/delete/question-file', 'QuestionBankController@deleteQuestionFile');




//Quiz Categories
Route::get('exams/categories', 'QuizCategoryController@index');
Route::get('exams/categories/add', 'QuizCategoryController@create');
Route::post('exams/categories/add', 'QuizCategoryController@store');
Route::get('exams/categories/edit/{slug}', 'QuizCategoryController@edit');
Route::patch('exams/categories/edit/{slug}', 'QuizCategoryController@update');
Route::delete('exams/categories/delete/{slug}', 'QuizCategoryController@delete');
Route::get('exams/categories/getList', [ 'as'   => 'quizcategories.dataTable',
    'uses' => 'QuizCategoryController@getDatatable']);

// Quiz Student Categories 
Route::get('exams/student/categories', 'StudentQuizController@index');
Route::get('exams/student/exams/{slug?}', 'StudentQuizController@exams');
Route::get('exams/student/quiz/getList/{slug?}', 'StudentQuizController@getDatatable');
Route::get('exams/student/quiz/take-exam/{slug?}', 'StudentQuizController@instructions');
Route::post('exams/student/start-exam/{slug}', 'StudentQuizController@startExam');
Route::get('exams/student/start-exam/{slug}', 'StudentQuizController@index');

Route::get('exams/student/get-scheduled-exams/{slug}', 'StudentQuizController@getScheduledExams');
Route::get('exams/student/load-scheduled-exams/{slug}', 'StudentQuizController@loadScheduledExams');


Route::post('exams/student/finish-exam/{slug}', 'StudentQuizController@finishExam');
Route::get('exams/student/reports/{slug}', 'StudentQuizController@reports');


Route::get('exams/student/exam-attempts/{user_slug}/{exam_slug?}', 'StudentQuizController@examAttempts');
Route::get('exams/student/get-exam-attempts/{user_slug}/{exam_slug?}', 'StudentQuizController@getExamAttemptsData');

Route::get('student/analysis/by-exam/{user_slug}', 'StudentQuizController@examAnalysis');
Route::get('student/analysis/get-by-exam/{user_slug}', 'StudentQuizController@getExamAnalysisData');

Route::get('student/analysis/by-subject/{user_slug}/{exam_slug?}/{results_slug?}', 'StudentQuizController@subjectAnalysisInExam');
Route::get('student/analysis/subject/{user_slug}', 'StudentQuizController@overallSubjectAnalysis');

//Student Reports
Route::get('student/exam/answers/{quiz_slug}/{result_slug}', 'ReportsController@viewExamAnswers');
Route::get('student/results/{slug}', 'ReportsController@viewAcademicResultsOfStudent');
Route::post('student/results/get-exam-categories', 'ReportsController@getExamCategories');
Route::post('student/results/get-exams', 'ReportsController@getExamsByCategory');


//Quiz 

//Exams ---dashboard
Route::get('exams/dashboard', 'QuizController@quizdashboard');
Route::get('exams/quizzes', 'QuizController@index');
Route::get('exams/quiz/add', 'QuizController@create');
Route::post('exams/quiz/add', 'QuizController@store');
Route::get('exams/quiz/edit/{slug}', 'QuizController@edit');
Route::patch('exams/quiz/edit/{slug}', 'QuizController@update');
Route::delete('exams/quiz/delete/{slug}', 'QuizController@delete');
Route::get('exams/quiz/getList/{slug?}', 'QuizController@getDatatable');

Route::get('exams/quiz/update-questions/{slug}', 'QuizController@updateQuestions');
Route::post('exams/quiz/update-questions/{slug}', 'QuizController@storeQuestions');


Route::post('exams/quiz/get-questions', 'QuizController@getSubjectData');

//Certificates controller
Route::get('result/generate-certificate/{slug}', 'CertificatesController@getCertificate');


//Exam Series 
Route::get('exams/exam-series', 'ExamSeriesController@index');
Route::get('exams/exam-series/add', 'ExamSeriesController@create');
Route::post('exams/exam-series/add', 'ExamSeriesController@store');
Route::get('exams/exam-series/edit/{slug}', 'ExamSeriesController@edit');
Route::patch('exams/exam-series/edit/{slug}', 'ExamSeriesController@update');
Route::delete('exams/exam-series/delete/{slug}', 'ExamSeriesController@delete');
Route::get('exams/exam-series/getList', 'ExamSeriesController@getDatatable');

//EXAM SERIES STUDENT LINKS
Route::get('exams/student-exam-series/list', 'ExamSeriesController@listSeries');
Route::get('exams/student-exam-series/{slug}', 'ExamSeriesController@viewItem');




Route::get('exams/exam-series/update-series/{slug}', 'ExamSeriesController@updateSeries');
Route::post('exams/exam-series/update-series/{slug}', 'ExamSeriesController@storeSeries');
Route::post('exams/exam-series/get-exams', 'ExamSeriesController@getExams');
Route::get('payment/cancel', 'ExamSeriesController@cancel');
Route::post('payment/success', 'ExamSeriesController@success');

            /////////////////////
            // PAYMENT REPORTS //
            /////////////////////
Route::get('payments-report/', 'PaymentsController@overallPayments');

 Route::get('payments-report/online/', 'PaymentsController@onlinePaymentsReport');
 Route::get('payments-report/online/{slug}', 'PaymentsController@listOnlinePaymentsReport');
Route::get('payments-report/online/getList/{slug}', 'PaymentsController@getOnlinePaymentReportsDatatable');

Route::get('payments-report/offline/', 'PaymentsController@offlinePaymentsReport');
Route::get('payments-report/offline/{slug}', 'PaymentsController@listOfflinePaymentsReport');
Route::get('payments-report/offline/getList/{slug}', 'PaymentsController@getOfflinePaymentReportsDatatable');
Route::get('payments-report/export', 'PaymentsController@exportPayments');
Route::post('payments-report/export', 'PaymentsController@doExportPayments');

Route::post('payments-report/getRecord', 'PaymentsController@getPaymentRecord');
Route::post('payments/approve-reject-offline-request', 'PaymentsController@approveOfflinePayment');

            //////////////////
            // INSTRUCTIONS  //
            //////////////////
            
Route::get('exam/instructions/list', 'InstructionsController@index');
Route::get('exam/instructions', 'InstructionsController@index');
Route::get('exams/instructions/add', 'InstructionsController@create');
Route::post('exams/instructions/add', 'InstructionsController@store');
Route::get('exams/instructions/edit/{slug}', 'InstructionsController@edit');
Route::patch('exams/instructions/edit/{slug}', 'InstructionsController@update');
Route::delete('exams/instructions/delete/{slug}', 'InstructionsController@delete');
Route::get('exams/instructions/getList', 'InstructionsController@getDatatable');

 
//BOOKMARKS MODULE
Route::get('student/bookmarks/{slug}', 'BookmarksController@index');
Route::post('student/bookmarks/add', 'BookmarksController@create');
Route::delete('student/bookmarks/delete/{id}', 'BookmarksController@delete');
Route::delete('student/bookmarks/delete_id/{id}', 'BookmarksController@deleteById');
Route::get('student/bookmarks/getList/{slug}',  'BookmarksController@getDatatable');
Route::post('student/bookmarks/getSavedList',  'BookmarksController@getSavedBookmarks');


                //////////////////////////
                // Notifications Module //
                /////////////////////////
Route::get('admin/notifications/list', 'NotificationsController@index');
Route::get('admin/notifications', 'NotificationsController@index');
Route::get('admin/notifications/add', 'NotificationsController@create');
Route::post('admin/notifications/add', 'NotificationsController@store');
Route::get('admin/notifications/edit/{slug}', 'NotificationsController@edit');
Route::patch('admin/notifications/edit/{slug}', 'NotificationsController@update');
Route::delete('admin/notifications/delete/{slug}', 'NotificationsController@delete');
Route::get('admin/notifications/getList', 'NotificationsController@getDatatable');

// NOTIFICATIONS FOR STUDENT
Route::get('notifications/list', 'NotificationsController@usersList');
Route::get('notifications/show/{slug}', 'NotificationsController@display');

 
//BOOKMARKS MODULE
Route::get('toppers/compare-with-topper/{user_result_slug}/{compare_slug?}', 'ExamToppersController@compare');

               
                        ////////////////
                        // LMS MODULE //
                        ////////////////

//LMS Categories
//Lms ---dashboard
Route::get('lms/dashboard', 'LmsCategoryController@lmsdashboard');
Route::get('lms/categories', 'LmsCategoryController@index');
Route::get('lms/categories/add', 'LmsCategoryController@create');
Route::post('lms/categories/add', 'LmsCategoryController@store');
Route::get('lms/categories/edit/{slug}', 'LmsCategoryController@edit');
Route::patch('lms/categories/edit/{slug}', 'LmsCategoryController@update');
Route::delete('lms/categories/delete/{slug}', 'LmsCategoryController@delete');
Route::get('lms/categories/getList', [ 'as'   => 'lmscategories.dataTable',
    'uses' => 'LmsCategoryController@getDatatable']);

//LMS Contents
Route::get('lms/content', 'LmsContentController@index');
Route::get('lms/content/add', 'LmsContentController@create');
Route::post('lms/content/add', 'LmsContentController@store');
Route::get('lms/content/edit/{slug}', 'LmsContentController@edit');
Route::patch('lms/content/edit/{slug}', 'LmsContentController@update');
Route::delete('lms/content/delete/{slug}', 'LmsContentController@delete');
Route::get('lms/content/getList', [ 'as'   => 'lmscontent.dataTable',
    'uses' => 'LmsContentController@getDatatable']);



//LMS Series 
Route::get('lms/series', 'LmsSeriesController@index');
Route::get('lms/series/add', 'LmsSeriesController@create');
Route::post('lms/series/add', 'LmsSeriesController@store');
Route::get('lms/series/edit/{slug}', 'LmsSeriesController@edit');
Route::patch('lms/series/edit/{slug}', 'LmsSeriesController@update');
Route::delete('lms/series/delete/{slug}', 'LmsSeriesController@delete');
Route::get('lms/series/getList', 'LmsSeriesController@getDatatable');

//LMS SERIES STUDENT LINKS
Route::get('lms/exam-series/list', 'LmsSeriesController@listSeries');
Route::get('lms/exam-series/{slug}', 'LmsSeriesController@viewItem');




Route::get('lms/series/update-series/{slug}', 'LmsSeriesController@updateSeries');
Route::post('lms/series/update-series/{slug}', 'LmsSeriesController@storeSeries');
Route::post('lms/series/get-series', 'LmsSeriesController@getSeries');
Route::get('payment/cancel', 'LmsSeriesController@cancel');
Route::post('payment/success', 'LmsSeriesController@success');


//LMS Student view
Route::get('learning-management/categories', 'StudentLmsController@index');
Route::get('learning-management/view/{slug}', 'StudentLmsController@viewCategoryItems');
Route::get('learning-management/series', 'StudentLmsController@series');
Route::get('learning-management/series/{slug}/{content_slug?}', 'StudentLmsController@viewItem');
Route::get('learning-management/content/{req_content_type}', 'StudentLmsController@content');
Route::get('learning-management/content/show/{slug}', 'StudentLmsController@showContent');
Route::get('user/paid/{slug}/{content_slug}', 'StudentLmsController@verifyPaidItem');


 

//Payments Controller
Route::get('payments/list/{slug}', 'PaymentsController@index');
Route::get('payments/getList/{slug}', 'PaymentsController@getDatatable');

Route::get('payments/checkout/{type}/{slug}', 'PaymentsController@checkout');

Route::post('payments/paynow/{slug}', 'PaymentsController@paynow');
Route::post('payments/paypal/status-success','PaymentsController@paypal_success');
Route::get('payments/paypal/status-cancel', 'PaymentsController@paypal_cancel');

Route::post('payments/payu/status-success','PaymentsController@payu_success');
Route::post('payments/payu/status-cancel', 'PaymentsController@payu_cancel');
Route::post('payments/offline-payment/update', 'PaymentsController@updateOfflinePayment');

                    
 

                        ////////////////////////////
                        // SETTINGS MODULE //
                        ///////////////////////////


//LMS Categories

//Settings ---dashboard
Route::get('settings/dashboard', 'SettingsController@settingsDashboard');
Route::get('mastersettings/settings/', 'SettingsController@index');
Route::get('mastersettings/settings/index', 'SettingsController@index');
Route::get('mastersettings/settings/certificates', 'SettingsController@certificatesdashboard');
Route::get('mastersettings/settings/timetable', 'SettingsController@timetabledashboard');
Route::get('mastersettings/settings/add', 'SettingsController@create');
Route::post('mastersettings/settings/add', 'SettingsController@store');
Route::get('mastersettings/settings/edit/{slug}', 'SettingsController@edit');
Route::patch('mastersettings/settings/edit/{slug}', 'SettingsController@update');
Route::get('mastersettings/settings/view/{slug}', 'SettingsController@viewSettings');
Route::get('mastersettings/settings/add-sub-settings/{slug}', 'SettingsController@addSubSettings');
Route::post('mastersettings/settings/add-sub-settings/{slug}', 'SettingsController@storeSubSettings');
Route::patch('mastersettings/settings/add-sub-settings/{slug}', 'SettingsController@updateSubSettings');
 
Route::get('mastersettings/settings/getList', [ 'as'   => 'mastersettings.dataTable',
     'uses' => 'SettingsController@getDatatable']);


                        ////////////////////////////
                        // MODULE HELPERS  MODULE //
                        ///////////////////////////

Route::get('mastersettings/module-helpers', 'ModuleHelperController@index');
Route::get('mastersettings/module-helpers/index', 'ModuleHelperController@index');
Route::get('mastersettings/module-helpers/add', 'ModuleHelperController@create');
Route::post('mastersettings/module-helpers/add', 'ModuleHelperController@store');
Route::get('mastersettings/module-helpers/edit/{slug}', 'ModuleHelperController@edit');
Route::patch('mastersettings/module-helpers/edit/{slug}', 'ModuleHelperController@update');
Route::get('mastersettings/module-helpers/view/{slug}', 'ModuleHelperController@viewSettings');
Route::get('mastersettings/module-helpers/add-sub-settings/{slug}', 'ModuleHelperController@addSubSettings');
// Route::post('mastersettings/module-helpers/add-sub-settings/{slug}', 'ModuleHelperController@storeSubSettings');
Route::patch('mastersettings/module-helpers/add-steps/{slug}', 'ModuleHelperController@updateSteps');
 
Route::get('mastersettings/module-helpers/getList', [ 'as'   => 'mastersettings.module-helper.dataTable',
     'uses' => 'ModuleHelperController@getDatatable']);

                        ////////////////////////////
                        // EMAIL TEMPLATES MODULE //
                        ///////////////////////////

//LMS Categories
Route::get('email/templates', 'EmailTemplatesController@index');
Route::get('email/templates/add', 'EmailTemplatesController@create');
Route::post('email/templates/add', 'EmailTemplatesController@store');
Route::get('email/templates/edit/{slug}', 'EmailTemplatesController@edit');
Route::patch('email/templates/edit/{slug}', 'EmailTemplatesController@update');
Route::delete('email/templates/delete/{slug}', 'EmailTemplatesController@delete');
Route::get('email/templates/getList', [ 'as'   => 'emailtemplates.dataTable',
    'uses' => 'EmailTemplatesController@getDatatable']);


//Coupons Module
Route::get('coupons/list', 'CouponcodesController@index');
Route::get('coupons/add', 'CouponcodesController@create');
Route::post('coupons/add', 'CouponcodesController@store');
Route::get('coupons/edit/{slug}', 'CouponcodesController@edit');
Route::patch('coupons/edit/{slug}', 'CouponcodesController@update');
Route::delete('coupons/delete/{slug}', 'CouponcodesController@delete');
Route::get('coupons/getList/{slug?}', 'CouponcodesController@getDatatable');

Route::get('coupons/get-usage', 'CouponcodesController@getCouponUsage');
Route::get('coupons/get-usage-data', 'CouponcodesController@getCouponUsageData');
Route::post('coupons/update-questions/{slug}', 'CouponcodesController@storeQuestions');


Route::post('coupons/validate-coupon', 'CouponcodesController@validateCoupon');


//Feedback Module
Route::get('feedback/list', 'FeedbackController@index');
Route::get('feedback/view-details/{slug}', 'FeedbackController@details');
Route::get('feedback/send', 'FeedbackController@create');
Route::post('feedback/send', 'FeedbackController@store');
Route::delete('feedback/delete/{slug}', 'FeedbackController@delete');
Route::get('feedback/getlist', 'FeedbackController@getDatatable');

//SMS Module

Route::get('sms/index', 'SMSAgentController@index');
Route::post('sms/send', 'SMSAgentController@sendSMS');

                        /////////////////////
                        // MESSAGES MODULE //
                        /////////////////////


Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});


                        //////////////////////
                        //Attendance Module //
                        //////////////////////
//Student attendance
Route::get('student/attendance/report', 'StudentAttendanceReportController@index');
Route::get('student/attendance/{slug}', 'StudentAttendanceController@index');
Route::get('student/attendance/add/{slug}', 'StudentAttendanceController@index');
Route::post('student/attendance/add/{slug}', 'StudentAttendanceController@create');
Route::post('student/attendance/update/{slug}', 'StudentAttendanceController@updateAtt');
Route::get('student/attendance/edit/{slug}', 'StudentAttendanceController@edit');
Route::patch('student/attendance/edit/{slug}', 'StudentAttendanceController@update');
Route::delete('student/attendance/delete/{id}', 'StudentAttendanceController@delete');
Route::get('student/attendance/getList', [ 'as'   => 'attendance.dataTable',
    'uses' => 'StudentAttendanceController@getDatatable']);    





//Student Attendence Report


Route::get('student/attendance/reports/{slug}', 'StudentAttendanceReportController@viewStudentAttendance');
Route::post('student/attendance/reports/get-attendance', 'StudentAttendanceReportController@getAttendance');
Route::post('student/attendance/reports/count-attendance', 'StudentAttendanceReportController@countAttendance');

Route::get('student/class-attendance', 'StudentAttendanceReportController@classAttendance');
Route::post('student/class-attendance', 'StudentAttendanceReportController@getClassAttendance');
Route::post('student/class-attendance/print', 'StudentAttendanceReportController@printClassAttendance');
Route::post('lessionplan/by-attendance', 'StudentAttendanceReportController@getLessionPlansLatestRecords');                   


                        //////////////////////////
                        // STUDENT MARKS MODULE //
                        //////////////////////////

Route::get('student/class-marks', 'StudentMarksReportController@classMarks');
Route::post('student/class-offline-exams-list', 'StudentMarksReportController@offlineExamsList');
Route::post('student/class-marks', 'StudentMarksReportController@getClassMarks');
Route::post('student/class-marks/offline-exams/print', 'StudentMarksReportController@printClassMarks');

//Student List According to the class

Route::get('student/list', 'StudentListController@index');
Route::post('student/list/classwise/print', 'StudentListController@printStudentList');
Route::get('student/completed/list', 'StudentListController@courseCompltedStudentsList');
Route::post('student/completed/list/print', 'StudentListController@printCourseCompltedStudentsList');
Route::get('student/detained/list', 'StudentListController@courseDetainedStudentsList');
Route::post('student/detained/list/print', 'StudentListController@printCourseDetainedStudentsList');
// Route::post('student/class-offline-exams-list', 'StudentMarksReportController@offlineExamsList');
// Route::post('student/class-marks', 'StudentMarksReportController@getClassMarks');


// LESSION PLANS MODULE
Route::get('staff/lession-plans/{slug}', 'LessionPlansController@index');
Route::get('staff/lession-plans/view-topics/{userSlug}/{courseSlug}', 'LessionPlansController@viewTopics');
Route::post('staff/lession-plans/update-topic', 'LessionPlansController@updateTopic');
Route::post('staff/lession-plans/get-last-updated-records', 'LessionPlansController@getLastUpdatedRecords');
Route::get('staff/lession-plans/student-list/{slug}', 'LessionPlansController@studentlist');
Route::post('staff/lession-plans/view-students', 'LessionPlansController@viewStudents');

Route::get('staff/lession-plans/view-students/get-list/{academic_id}/{course_parent_id}/{course_id}/{year}/{semister}', 'LessionPlansController@getDatatable');    



//STUDENT TRANSFERS
Route::get('student/transfers', 'StudentPromotionsController@index');
Route::post('student/transfers', 'StudentPromotionsController@transferStudents');

Route::post('student/transfer-single-student', 'StudentPromotionsController@transferSingleStudent');

//SEARCH STUDENT
Route::post('student/search', 'StudentController@globalStudentSearch');

//OFFLINE MARKS UPLOAD
Route::get('marks/upload', 'QuizResultsController@index');

//TIMETABLE MODULE
Route::get('timetable', 'TimetableController@index');


//Timingset 
Route::get('timetable/timing-set', 'TimingsetController@index');
Route::get('timetable/timing-set/add', 'TimingsetController@create');
Route::post('timetable/timing-set/add', 'TimingsetController@store');
Route::get('timetable/timing-set/edit/{slug}', 'TimingsetController@edit');
Route::patch('timetable/timing-set/edit/{slug}', 'TimingsetController@update');
Route::delete('timetable/timing-set/delete/{slug}', 'TimingsetController@delete');
Route::delete('timetable/timing-set/delete-timingset-record/{slug}', 'TimingsetController@deleteTimingsetRecord');
Route::get('timetable/timing-set/getList', [ 'as'   => 'timingset.dataTable',
    'uses' => 'TimingsetController@getDatatable']);


//Allot time table
Route::get('timetable/allot-timetable', 'TimetableController@viewTimetable');
// Route::get('timetable/print', 'TimetableController@printTimetable');
Route::post('timetable/print', 'TimetableController@printTimetable');

Route::post('timetable/get-timetable-details', 'TimetableController@getAllocatedStaffAndTimings');

Route::post('timetable/update-timetable', 'TimetableController@updateTimetable');
Route::post('timetable/is-available', 'TimetableController@checkStaffIsAvailable');

Route::get('timetable/user/{slug}', 'TimetableController@staffTimetable');
Route::get('timetable/print/{slug}', 'TimetableController@printStaffStudentTimetable');


//Timing Map
Route::get('timetable/map-timingset/{slug}', 'MapTimingsetController@create');
Route::post('timetable/map-timingset/add/{slug}', 'MapTimingsetController@store');


//Timing Map Parent list
Route::get('maptimingset/parent', 'MapTimingSetParentController@index');
Route::get('maptimingset/parent/add', 'MapTimingSetParentController@create');
Route::post('maptimingset/parent/add', 'MapTimingSetParentController@store');
Route::get('maptimingset/parent/edit/{slug}', 'MapTimingSetParentController@edit');
Route::patch('maptimingset/parent/edit/{slug}', 'MapTimingSetParentController@update');
Route::delete('maptimingset/parent/delete/{id}', 'MapTimingSetParentController@delete');
Route::get('maptimingset/parent/getList', [ 'as'   => 'maptimingsetparent.dataTable',
    'uses' => 'MapTimingSetParentController@getDatatable']);
Route::get('maptimingset/parent/get-academics', 'MapTimingSetParentController@getAcademics');



//Transportation Vechicles
Route::get('transportation/vehicles', 'TransportationController@index');
Route::get('transportation/vehicles/add', 'TransportationController@create');
Route::post('transportation/vehicles/add', 'TransportationController@store');
Route::get('transportation/vehicles/edit/{slug}', 'TransportationController@edit');
Route::patch('transportation/vehicles/edit/{slug}', 'TransportationController@update');
Route::delete('transportation/vehicles/delete/{id}', 'TransportationController@delete');
Route::get('transportation/vehicles/getlist', [ 'as'   => 'transportationvehicles.dataTable',
    'uses' => 'TransportationController@getDatatable']);


//Transportation Vechicles types
Route::get('transportation/vehicles/types', 'TransportationVehicletypeController@index');
Route::get('transportation/vehicles/types/add', 'TransportationVehicletypeController@create');
Route::post('transportation/vehicles/types/add', 'TransportationVehicletypeController@store');
Route::get('transportation/vehicles/types/edit/{slug}', 'TransportationVehicletypeController@edit');
Route::patch('transportation/vehicles/types/edit/{slug}', 'TransportationVehicletypeController@update');
Route::delete('transportation/vehicles/types/delete/{id}', 'TransportationVehicletypeController@delete');
Route::get('transportation/vehicles/types/getlist', [ 'as'   => 'transportationvehicletypes.dataTable',
    'uses' => 'TransportationVehicletypeController@getDatatable']);


//Offline Exams
Route::get('academicoperations/offline-exams', 'OfflineExamsController@index');
Route::get('academicoperations/offline-exams/exams/{slug}','OfflineExamsController@selectionview');
Route::post('academicoperations/offline-exams/add','OfflineExamsController@entermarks');
Route::post('academicoperations/offline-exams/store', 'OfflineExamsController@store');
Route::get('academicoperations/offline-exams/getlist', [ 'as'   => 'offlineexams.dataTable',
    'uses' => 'OfflineExamsController@getDatatable']);
 Route::delete('academicoperations/offline-exams/delete/{id}', 'OfflineExamsController@delete');


Route::get('academicoperations/offline-exams/import-excel', 'OfflineExamsController@import');
Route::post('academicoperations/offline-exams/import-excel', 'OfflineExamsController@readExcel');
Route::post('academicoperations/offline-exams/get-information', 'OfflineExamsController@getOfflineExamsInformation');



//OfflineExams Quiz Categories
Route::get('offlineexmas/quiz/categories', 'OfflineQuizCategoriesController@index');
Route::get('offlineexmas/quiz/categories/add', 'OfflineQuizCategoriesController@create');
Route::post('offlineexmas/quiz/categories/add', 'OfflineQuizCategoriesController@store');
Route::get('offlineexmas/quiz/categories/edit/{slug}', 'OfflineQuizCategoriesController@edit');
Route::patch('offlineexmas/quiz/categories/edit/{slug}', 'OfflineQuizCategoriesController@update');
Route::delete('offlineexmas/quiz/categories/delete/{id}', 'OfflineQuizCategoriesController@delete');
Route::get('offlineexmas/quiz/categories/getList', [ 'as'   => 'offlinequizcategories.dataTable',
    'uses' => 'OfflineQuizCategoriesController@getDatatable']);


//academic operations ---dashboard
Route::get('academicoperations/dashboard', 'AcademicOperationsDashboardController@index');

//Student Quiz dashboard
Route::get('student/quiz/dashboard', 'StudentQuizController@dashboard');

Route::get('user/search', 'SearchController@index');

Route::post('html/print-data', 'PrinterController@printHtml');

                          ////////////////////
                         // UPDATE PATCHES //
                         ////////////////////
 Route::get('updates/patch1', 'UpdatesController@patch1');
