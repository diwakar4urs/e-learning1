<?php

 $base = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
 $base .= '://'.$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
 // $base =  '/';

define('PREFIX', $base);

// dd($_SERVER);
//Design Source File Paths
define('CSS', PREFIX.'css/');
define('JS', PREFIX.'js/');
define('FONTAWSOME', PREFIX.'font-awesome/css/');
define('IMAGES', PREFIX.'images/');
define('UPLOADS', PREFIX.'uploads/');
define('EXAM_UPLOADS', UPLOADS.'exams/');

define('ANIMATION_ADD', 'fadeIn');
define('ANIMATION_REMOVE', 'fadeOut');

define('AJAXLOADER', IMAGES.'ajax-loader.svg');
define('AJAXLOADER_FADEIN_TIME', 100);
define('AJAXLOADER_FADEOUT_TIME', 100);

define('ATTENDANCE_COLOR_PRESENT', 'green');
define('ATTENDANCE_COLOR_ABSENT', 'red');
define('ATTENDANCE_COLOR_LEAVE', 'blue');
define('ATTENDANCE_COLOR_FORE_COLOR', 'white');

define('TIMETABLE_START_TIME', '7');
define('TIMETABLE_END_TIME', '17');




define('IMAGE_STUDENT_ICON', IMAGES.'system/graduate.png');
define('IMAGE_TEACHER_ICON', IMAGES.'system/teacher-pointing-blackboard.png');
define('IMAGE_ADMIN_ICON', IMAGES.'system/admin.png');

define('IMAGE_PATH_UPLOAD_SERIES', UPLOADS.'exams/series/');
define('IMAGE_PATH_UPLOAD_SERIES_THUMB', UPLOADS.'exams/series/thumb/');

define('IMAGE_PATH_USERS_THUMB', UPLOADS.'users/thumbnail/');
define('IMAGE_PATH_USERS_DEFAULT_THUMB', UPLOADS.'users/thumbnail/default.png');

define('IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT', UPLOADS.'exams/series/default.png');

define('IMAGE_PATH_UPLOAD_LMS_CATEGORIES', UPLOADS.'lms/categories/');
define('IMAGE_PATH_UPLOAD_LMS_DEFAULT', UPLOADS.'lms/categories/default.png');
define('IMAGE_PATH_UPLOAD_LMS_CONTENTS', UPLOADS.'lms/content/');


define('IMAGE_PATH_UPLOAD_TRANSPORTATION_VEHICLE', UPLOADS.'transportation/vehicletype/');
define('IMAGE_PATH_UPLOAD_TRANSPORTATION_DEFAULT', UPLOADS.'transportation/default.jpg');

define('IMAGE_PATH_UPLOAD_LMS_SERIES', UPLOADS.'lms/series/');
define('IMAGE_PATH_UPLOAD_LMS_SERIES_THUMB', UPLOADS.'lms/series/thumb/');


define('IMAGE_PATH_PROFILE', UPLOADS.'users/');
define('IMAGE_PATH_PROFILE_THUMBNAIL', UPLOADS.'users/thumbnail/');
define('IMAGE_PATH_PROFILE_DEFAULT_THUMBNAIL', UPLOADS.'users/thumbnail/default.png');
define('IMAGE_PATH_PROFILE_DEFAULT', UPLOADS.'users/default.png');

define('IMAGE_PATH_SETTINGS', UPLOADS.'settings/');

define('PDF_EXCEPTION_MENORAH_MESSAGE', '\n please install the extension available at http://phantomjs.org');


define('IMAGE_PATH_UPLOAD_LIBRARY', UPLOADS.'library/');
define('IMAGE_PATH_UPLOAD_LIBRARY_THUMB', UPLOADS.'library/thumbnail/');
define('IMAGE_PATH_UPLOAD_LIBRARY_DEFAULT', UPLOADS.'library/default.png');
define('IMAGE_PATH_UPLOAD_LIBRARY_DEFAULT_THUMB', UPLOADS.'library/thumbnail/default.png');



define('DOWNLOAD_LINK_USERS_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/users_template.xlsx');
define('DOWNLOAD_LINK_SUBJECTS_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/subjects_template.xlsx');
define('DOWNLOAD_LINK_TOPICS_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/topics_template.xlsx');
define('DOWNLOAD_LINK_QUESTION_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/');
define('DOWNLOAD_LINK_OFFLINE_MARKS_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/offline_marks_template.xlsx');


define('DOWNLOAD_EMPTY_DATA_DATABASE', PREFIX.'downloads/database/install.sql');
define('DOWNLOAD_SAMPLE_DATA_SCHOOL_DATABASE', PREFIX.'downloads/database/install_dummy_data_school.sql');
define('DOWNLOAD_SAMPLE_DATA_COLLEGE_DATABASE', PREFIX.'downloads/database/install_dummy_data_college.sql');
define('DOWNLOAD_SAMPLE_DATA_DEGREE_DATABASE', PREFIX.'downloads/database/install_dummy_data_degree.sql');
define('DOWNLOAD_SAMPLE_DATA_PG_DATABASE', PREFIX.'downloads/database/install_dummy_data_pg.sql');
define('DOWNLOAD_SAMPLE_DATA_UNIVERSITY_DATABASE', PREFIX.'downloads/database/install_dummy_data_university.sql');



define('CURRENCY_CODE', '$ ');
define('RECORDS_PER_PAGE', '8');
define('STUDENT_ROLE_ID', '5');

define('DEFAULT_CLASSES_NEEDED', '20');

define('PAYMENT_STATUS_CANCELLED', 'cancelled');
define('PAYMENT_STATUS_SUCCESS', 'success');
define('PAYMENT_STATUS_PENDING', 'pending');
define('PAYMENT_STATUS_ABORTED', 'aborted');
define('PAYMENT_RECORD_MAXTIME', '30'); //TIME IN MINUTES
//define('SUPPORTED_GATEWAYS', ['paypal','payu']); 

define('URL_INSTALL_SYSTEM', PREFIX.'install');
define('URL_UPDATE_INSTALLATATION_DETAILS', PREFIX.'update-details');
define('URL_FIRST_USER_REGISTER', PREFIX.'install/register');

//MASTER SETTINGS MODULE
define('URL_MASTERSETTINGS_SETTINGS', PREFIX.'mastersettings/settings');
define('URL_MASTERSETTINGS_EMAIL_TEMPLATES', PREFIX.'email/templates');
define('URL_MASTERSETTINGS_TOPICS', PREFIX.'mastersettings/topics');
define('URL_MASTERSETTINGS_SUBJECTS', PREFIX.'mastersettings/subjects');

//MASTER SETTINGS RELIGIONS
define('URL_MASTERSETTINGS_RELIGIONS', PREFIX.'mastersettings/religions');
define('URL_MASTERSETTINGS_RELIGIONS_ADD', PREFIX.'mastersettings/religions/add');
define('URL_MASTERSETTINGS_RELIGIONS_EDIT', PREFIX.'mastersettings/religions/edit/');
define('URL_MASTERSETTINGS_RELIGIONS_DELETE', PREFIX.'mastersettings/religions/delete/');
define('URL_MASTERSETTINGS_RELIGIONS_AJAXLIST', PREFIX.'mastersettings/religions/getList');

//MASTER SETTINGS CATEGORIES
define('URL_MASTERSETTINGS_CATEGORIES', PREFIX.'mastersettings/categories');
define('URL_MASTERSETTINGS_CATEGORIES_ADD', PREFIX.'mastersettings/categories/add');
define('URL_MASTERSETTINGS_CATEGORIES_EDIT', PREFIX.'mastersettings/categories/edit/');
define('URL_MASTERSETTINGS_CATEGORIES_DELETE', PREFIX.'mastersettings/categories/delete/');
define('URL_MASTERSETTINGS_CATEGORIES_AJAXLIST', PREFIX.'mastersettings/categories/getList');


//OFFLINEEXMAS QUIZ CATEGORIES
define('URL_OFFLINEEXMAS_QUIZ_CATEGORIES', PREFIX.'offlineexmas/quiz/categories');
define('URL_OFFLINEEXMAS_QUIZ_CATEGORIES_ADD', PREFIX.'offlineexmas/quiz/categories/add');
define('URL_OFFLINEEXMAS_QUIZ_CATEGORIES_EDIT', PREFIX.'offlineexmas/quiz/categories/edit/');
define('URL_OFFLINEEXMAS_QUIZ_CATEGORIES_DELETE', PREFIX.'offlineexmas/quiz/categories/delete/');
define('URL_OFFLINEEXMAS_QUIZ_CATEGORIES_AJAXLIST', PREFIX.'offlineexmas/quiz/categories/getList');


//MASTER SETTINGS ACADEMICS
define('URL_MASTERSETTINGS_ACADEMICS', PREFIX.'mastersettings/academics');
define('URL_MASTERSETTINGS_ACADEMICS_ADD', PREFIX.'mastersettings/academics/add');
define('URL_MASTERSETTINGS_ACADEMICS_EDIT', PREFIX.'mastersettings/academics/edit/');
define('URL_MASTERSETTINGS_ACADEMICS_DELETE', PREFIX.'mastersettings/academics/delete/');
define('URL_MASTERSETTINGS_ACADEMICS_AJAXLIST', PREFIX.'mastersettings/academics/getList');

//MASTER SETTINGS SET ACADEMIC COURSES
define('URL_MASTERSETTINGS_ACADEMICS_COURSES', PREFIX.'mastersettings/academic-courses/');
define('URL_MASTERSETTINGS_ACADEMICS_COURSES_STATUS', PREFIX.'mastersettings/academic-courses/check-status');
define('URL_ACADEMICS_COURSES_GET_PARENT_COURSES', PREFIX.'academic-courses/get-parent-courses');
define('URL_ACADEMICS_COURSES_GET_CHILD_COURSES', PREFIX.'academic-courses/get-child-courses');
define('URL_ACADEMICS_REMOVE_SUBJECT', PREFIX.'academic-courses/remove-subject');

//MASTER SETTINGS COURSE
define('URL_MASTERSETTINGS_COURSE', PREFIX.'mastersettings/course');
define('URL_MASTERSETTINGS_COURSE_ADD', PREFIX.'mastersettings/course/add');
define('URL_MASTERSETTINGS_COURSE_EDIT', PREFIX.'mastersettings/course/edit/');
define('URL_MASTERSETTINGS_COURSE_DELETE', PREFIX.'mastersettings/course/delete/');
define('URL_MASTERSETTINGS_COURSE_AJAXLIST', PREFIX.'mastersettings/course/getList');

define('URL_MASTERSETTINGS_COURSE_EDIT_SEMISTER', PREFIX.'mastersettings/course/editSemisters');

//MASTER SETTINGS CERTIFICATE TEMPLATE
define('URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES', PREFIX.'mastersettings/certificate_templates');
define('URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES_ADD', PREFIX.'mastersettings/certificate_templates/add');
define('URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES_EDIT', PREFIX.'mastersettings/certificate_templates/edit/');
define('URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES_DELETE', PREFIX.'mastersettings/certificate_templates/delete/');
define('URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES_GETLIST', PREFIX.'mastersettings/certificate_templates/getlist');

define('URL_CERTIFICATES_DASHBOARD', PREFIX.'certificates/dashboard');
define('URL_CERTIFICATES_GENERATE_IDCARD', PREFIX.'certificates/id-cards');
define('URL_CERTIFICATE_BONAFIDE', PREFIX.'certificates/bonafide-certificates');
define('URL_CERTIFICATES_GET_USERS', PREFIX.'certificates/id-cards');
define('URL_GET_STUDENTS', PREFIX.'students/get-users');
define('URL_GET_STUDENTS_COURSE_COMPLETED', PREFIX.'students/get-users/completed');
define('URL_GET_STUDENTS_DETAINED', PREFIX.'students/get-users/detained');


//MASTER SETTINGS ACADEMIC HOLIDAYS
define('URL_MASTERSETTINGS_HOLIDAYS', PREFIX.'mastersettings/holidays');
define('URL_MASTERSETTINGS_HOLIDAYS_ADD', PREFIX.'mastersettings/holidays/add');
define('URL_MASTERSETTINGS_HOLIDAYS_EDIT', PREFIX.'mastersettings/holidays/edit/');
define('URL_MASTERSETTINGS_HOLIDAYS_DELETE', PREFIX.'mastersettings/holidays/delete/');
define('URL_MASTERSETTINGS_GETLIST', PREFIX.'mastersettings/holidays/getlist');

//MASTER SETTINGS COURSE SUBJECTS
define('URL_MASTERSETTINGS_COURSE_SUBJECTS', PREFIX.'mastersettings/course-subjects/');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_LIST', PREFIX.'mastersettings/course-subjects');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD', PREFIX.'mastersettings/course-subjects/add');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_EDIT', PREFIX.'mastersettings/course-subjects/edit/');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_DELETE', PREFIX.'mastersettings/course-subjects/delete/');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_AJAXLIST', PREFIX.'mastersettings/course-subjects/getList/');
define('URL_SUBJECTS_VIEW_TOPICS', PREFIX.'subjects/view-topics/');

define('URL_MASTERSETTINGS_COURSE_SUBJECTS_GET_COURSE_YEARS', PREFIX.'mastersettings/course-subjects/getCourseYears');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_GET_COURSE_SEMISTERS', PREFIX.'mastersettings/course-subjects/getSemisters');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_GET_COURSE_SAVED_SUBJECTS', PREFIX.'mastersettings/course-subjects/getSavedSubjects');
define('URL_MASTERSETTINGS_COURSE_SUBJECTS_GET_COURSE_SUBJECTS_SHOW', PREFIX.'mastersettings/course-subjects/show/');
define('URL_MASTERSETTINGS_STUDENT_COURSES', PREFIX.'student/courses/');

define('URL_MASTERSETTINGS_COURSE_SUBJECTS_LOAD', PREFIX.'mastersettings/course-subjects/load');

define('URL_COURSE_SUBJECTS_ADD_STAFF', PREFIX.'course-subjects/add-staff/');
define('URL_COURSE_SUBJECTS_UPDATE_STAFF', PREFIX.'course-subjects/update-staff');
define('URL_IS_STAFF_ALLOCATED_TO_TIMETABLE', PREFIX.'course-subjects/is-staff-allocated');


//FEE SETTINGS--FEE CATEGORIES
define('URL_FEE_CATEGORIES', PREFIX.'fee/categories');
define('URL_FEE_CATEGORIES_ADD', PREFIX.'fee/categories/add');
define('URL_FEE_CATEGORIES_EDIT', PREFIX.'fee/categories/edit/');
define('URL_FEE_CATEGORIES_DELETE', PREFIX.'fee/categories/delete/');
define('URL_FEE_CATEGORIES_AJAXLIST', PREFIX.'fee/categories/getList');

//FEE SETTINGS--FEE CATEGORIES
define('URL_FEE_CATEGORIES_ALLOT', PREFIX.'fee/categories/allot-category');
define('URL_FEE_CATEGORIES_GET_ALLOT_CATEGORIES', PREFIX.'fee/categories/get_alloted-categories');


//FEE SETTINGS--FEE PARTICULARS
define('URL_FEE_PARTICULARS', PREFIX.'fee/particulars');
define('URL_FEE_PARTICULARS_ADD', PREFIX.'fee/particulars/add');
define('URL_FEE_PARTICULARS_EDIT', PREFIX.'fee/particulars/edit/');
define('URL_FEE_PARTICULARS_DELETE', PREFIX.'fee/particulars/delete/');
define('URL_FEE_PARTICULARS_AJAXLIST', PREFIX.'fee/particulars/getList');

//FEE SETTINGS--FEE SCHEDULES
define('URL_FEE_SCHEDULES', PREFIX.'fee/schedules');
define('URL_FEE_SCHEDULES_ADD', PREFIX.'fee/schedules/add');
define('URL_FEE_SCHEDULES_EDIT', PREFIX.'fee/schedules/edit/');
define('URL_FEE_SCHEDULES_DELETE', PREFIX.'fee/schedules/delete/');

define('URL_FEE_SCHEDULES_AJAXLIST', PREFIX.'fee/schedules/getList');
define('URL_FEE_SCHEDULES_GET_SCHEDULED_COURSES', PREFIX.'fee/schedules/getScheduledCourses');

//FEE SETTINGS--FEE FINES
define('URL_FEE_FINES', PREFIX.'fee/fines');
define('URL_FEE_FINES_ADD', PREFIX.'fee/fines/add');
define('URL_FEE_FINES_EDIT', PREFIX.'fee/fines/edit/');
define('URL_FEE_FINES_DELETE', PREFIX.'fee/fines/delete/');
define('URL_FEE_FINES_AJAXLIST', PREFIX.'fee/fines/getList');


//FEE SETTINGS--FEE DISCOUNTS
define('URL_FEE_DISCOUNTS', PREFIX.'fee/feediscounts');
define('URL_FEE_DISCOUNTS_ADD', PREFIX.'fee/feediscounts/add');
define('URL_FEE_DISCOUNTS_EDIT', PREFIX.'fee/feediscounts/edit/');
define('URL_FEE_DISCOUNTS_DELETE', PREFIX.'fee/feediscounts/delete/');
define('URL_FEE_DISCOUNTS_AJAXLIST', PREFIX.'fee/feediscounts/getList');



//QUIZ MODULE
define('URL_QUIZZES', PREFIX.'exams/quizzes');
define('URL_QUIZ_QUESTIONBANK', PREFIX.'exams/questionbank');
define('URL_QUIZ_ADD', PREFIX.'exams/quiz/add');
define('URL_QUIZ_EDIT', PREFIX.'exams/quiz/edit');
define('URL_QUIZ_DELETE', PREFIX.'exams/quiz/delete/');
define('URL_QUIZ_GETLIST', PREFIX.'exams/quiz/getList');
define('URL_QUIZ_UPDATE_QUESTIONS', PREFIX.'exams/quiz/update-questions/');
define('URL_QUIZ_GET_QUESTIONS', PREFIX.'exams/quiz/get-questions');

//QUIZ CATEGORIES
define('URL_QUIZ_CATEGORIES', PREFIX.'exams/categories');
define('URL_QUIZ_CATEGORY_EDIT', PREFIX.'exams/categories/edit');
define('URL_QUIZ_CATEGORY_ADD', PREFIX.'exams/categories/add');
define('URL_QUIZ_CATEGORY_DELETE', PREFIX.'exams/categories/delete/');

//QUESTIONSBANK MODULE
define('URL_QUESTIONBANK_VIEW', PREFIX.'exams/questionbank/view/');
define('URL_QUESTIONBANK_ADD_QUESTION', PREFIX.'exams/questionbank/add-question/');
define('URL_QUESTIONBANK_EDIT_QUESTION', PREFIX.'exams/questionbank/edit-question/');
define('URL_QUESTIONBANK_EDIT', PREFIX.'exams/questionbank/edit');
define('URL_QUESTIONBANK_ADD', PREFIX.'exams/questionbank/add');
define('URL_QUESTIONBANK_GETLIST', PREFIX.'exams/questionbank/getList');
define('URL_QUESTIONBANK_DELETE', PREFIX.'exams/questionbank/delete/');
define('URL_QUESTIONBANK_GETQUESTION_LIST', PREFIX.'exams/questionbank/getquestionslist/');
define('URL_QUESTIONBANK_DELETE_QUESTIONFILE', PREFIX.'exams/questionbank/delete/question-file');
define('URL_QUESTIONBANK_DELETE_OPTIONFILE', PREFIX.'exams/questionbank/delete/option-file/');


define('URL_QUESTIONBAMK_IMPORT', PREFIX.'exams/questionbank/import');

//SUBJECTS MODULE
define('URL_SUBJECTS', PREFIX.'mastersettings/subjects');
define('URL_SUBJECTS_ADD', PREFIX.'mastersettings/subjects/add');
define('URL_SUBJECTS_EDIT', PREFIX.'mastersettings/subjects/edit');
define('URL_SUBJECTS_DELETE', PREFIX.'mastersettings/subjects/delete/');

define('URL_SUBJECTS_IMPORT', PREFIX.'mastersettings/subjects/import');


//TOPICS MODULE
define('URL_TOPICS', PREFIX.'mastersettings/topics');
define('URL_TOPICS_LIST', PREFIX.'mastersettings/topics/list');
define('URL_TOPICS_ADD', PREFIX.'mastersettings/topics/add');
define('URL_TOPICS_EDIT', PREFIX.'mastersettings/topics/edit');
define('URL_TOPICS_DELETE', PREFIX.'mastersettings/topics/delete/');
define('URL_TOPICS_GET_PARENT_TOPICS', PREFIX.'mastersettings/topics/get-parents-topics/');

define('URL_TOPICS_IMPORT', PREFIX.'mastersettings/topics/import');
//EMAIL TEMPLATES MODULE
define('URL_EMAIL_TEMPLATES', PREFIX.'email/templates');
define('URL_EMAIL_TEMPLATES_ADD', PREFIX.'email/templates/add');
define('URL_EMAIL_TEMPLATES_EDIT', PREFIX.'email/templates/edit');
define('URL_EMAIL_TEMPLATES_DELETE', PREFIX.'email/templates/delete/');

//INSTRUCTIONS MODULE
define('URL_INSTRUCTIONS', PREFIX.'exam/instructions/list');
define('URL_INSTRUCTIONS_ADD', PREFIX.'exams/instructions/add');
define('URL_INSTRUCTIONS_EDIT', PREFIX.'exams/instructions/edit/');
define('URL_INSTRUCTIONS_DELETE', PREFIX.'exams/instructions/delete/');
define('URL_INSTRUCTIONS_GETLIST', PREFIX.'exams/instructions/getList');

//LANGUAGES MODULE
define('URL_LANGUAGES_LIST', PREFIX.'languages/list');
define('URL_LANGUAGES_ADD', PREFIX.'languages/add');
define('URL_LANGUAGES_EDIT', PREFIX.'languages/edit');
define('URL_LANGUAGES_UPDATE_STRINGS', PREFIX.'languages/update-strings/');
define('URL_LANGUAGES_DELETE', PREFIX.'languages/delete/');
define('URL_LANGUAGES_GETLIST', PREFIX.'languages/getList/');
define('URL_LANGUAGES_MAKE_DEFAULT', PREFIX.'languages/make-default/');
 
//SETTINGS MODULE
define('URL_SETTINGS_LIST', PREFIX.'mastersettings/settings');
define('URL_SETTINGS_VIEW', PREFIX.'mastersettings/settings/view/');
define('URL_SETTINGS_ADD', PREFIX.'mastersettings/settings/add');
define('URL_SETTINGS_CERTIFICATES', PREFIX.'mastersettings/settings/certificates');
define('URL_SETTINGS_TIMETABLE', PREFIX.'mastersettings/settings/timetable');
define('URL_SETTINGS_EDIT', PREFIX.'mastersettings/settings/edit/');
define('URL_SETTINGS_DELETE', PREFIX.'mastersettings/settings/delete/');
define('URL_SETTINGS_GETLIST', PREFIX.'mastersettings/settings/getList/');
define('URL_SETTINGS_ADD_SUBSETTINGS', PREFIX.'mastersettings/settings/add-sub-settings/');

 
 
// MODULE HELPERS
define('URL_MODULEHELPERS_LIST', PREFIX.'mastersettings/module-helpers');
define('URL_MODULEHELPERS_VIEW', PREFIX.'mastersettings/module-helpers/view/');
define('URL_MODULEHELPERS_ADD', PREFIX.'mastersettings/module-helpers/add');
define('URL_MODULEHELPERS_EDIT', PREFIX.'mastersettings/module-helpers/edit/');
define('URL_MODULEHELPERS_DELETE', PREFIX.'mastersettings/module-helpers/delete/');
define('URL_MODULEHELPERS_GETLIST', PREFIX.'mastersettings/module-helpers/getList/');
define('URL_MODULEHELPERS_ADD_STEPS', PREFIX.'mastersettings/module-helpers/add-steps/');

 


//CONSTANST FOR USERS MODULE
define('URL_USERS', PREFIX.'users/');
define('URL_USER_DETAILS', PREFIX.'users/details/');
define('URL_STAFF_EDIT_PROFILE_STATUS', PREFIX.'users/change-status');
define('URL_USER_TRANSFERS_DETAILS', PREFIX.'users/details/promotions/');
define('URL_USER_LIBRARY_DETAILS', PREFIX.'users/details/library/');
define('URL_USER_LIBRARY_DETAILS_GETLIST', PREFIX.'users/details/library/get-list/');
define('URL_STAFF_DETAILS', PREFIX.'staff/details/');
define('URL_USERS_EDIT', PREFIX.'users/edit/');
define('URL_USERS_ADD', PREFIX.'users/create');
define('URL_USERS_DELETE', PREFIX.'users/delete/');
define('URL_USERS_SETTINGS', PREFIX.'users/settings/');
define('URL_USERS_CHANGE_PASSWORD', PREFIX.'users/change-password/');
define('URL_USERS_LOGOUT', PREFIX.'logout');
define('URL_PARENT_LOGOUT', PREFIX.'parent-logout');
define('URL_USERS_REGISTER', PREFIX.'register');
define('URL_USERS_LOGIN', PREFIX.'login');

define('URL_USERS_IMPORT', PREFIX.'users/import');
define('URL_USERS_IMPORT_REPORT', PREFIX.'users/import-report');
define('URL_USERS_IMPORT_EXCEL_INFORMATION', PREFIX.'users/import/get-excel-information');

define('URL_FORGOT_PASSWORD', PREFIX.'users/forgot-password');

//USERS

define('URL_USERS_LIST', PREFIX.'users/list/');
define('URL_USERS_LIST_GETLIST', PREFIX.'users/list/getList/');


//STAFF
define('URL_STAFF_PROFILE', PREFIX.'staff/profile/');
define('URL_STAFF_EDIT_PROFILE', PREFIX.'staff/profile/edit/');
define('URL_USERS_STAFF_INACTIVE', PREFIX.'users/staff-inactive/');
define('URL_USERS_STAFF_INACTIVE_GETLIST', PREFIX.'users/staff-inactive/getList/');

define('URL_STAFF_EDIT_PROFILE_GENERAL', PREFIX.'staff/profile/edit/general/');
define('URL_STAFF_EDIT_PROFILE_PERSONAL', PREFIX.'staff/profile/edit/personal/');
define('URL_STAFF_EDIT_PROFILE_CONTACT', PREFIX.'staff/profile/edit/contact/');

//STAFF SUBJECT PREFERENCES
define('URL_STAFF_SUBJECT_PREFERENCES', PREFIX.'staff/subjects/preferences/');




			///////////////////
			//STUDENT MODULE //
			///////////////////

//STUDENT NAVIGATION
define('URL_STUDENT_EXAM_CATEGORIES', PREFIX.'exams/student/categories');
define('URL_STUDENT_EXAM_ATTEMPTS', PREFIX.'exams/student/exam-attempts/');
define('URL_STUDENT_ANALYSIS_SUBJECT', PREFIX.'student/analysis/subject/');
define('URL_STUDENT_ANALYSIS_BY_EXAM', PREFIX.'student/analysis/by-exam/');
define('URL_STUDENT_SUBSCRIPTIONS_PLANS', PREFIX.'subscription/plans');
define('URL_STUDENT_LIST_INVOICES', PREFIX.'subscription/list-invoices/');


define('URL_STUDENT_PROFILE', PREFIX.'student/profile/');
define('URL_STUDENT_EDIT_PROFILE', PREFIX.'student/profile/edit/');
define('URL_STUDENT_EDIT_PROFILE_GENERAL', PREFIX.'student/profile/edit/general/');
define('URL_STUDENT_EDIT_PROFILE_PERSONAL', PREFIX.'student/profile/edit/personal/');
define('URL_STUDENT_EDIT_PROFILE_CONTACT', PREFIX.'student/profile/edit/contact/');
define('URL_SEARCH_PARENT_RECORDS', PREFIX.'student/get-parent-records');

define('URL_STUDENT_COURSES', PREFIX.'student/courses');
define('URL_STUDENT_COURSE_SEMISTER', PREFIX.'student/course-semister/');


///////////////////
// STUDENT EXAMS //
///////////////////
define('URL_STUDENT_EXAM_ALL', PREFIX.'exams/student/exams/all');
define('URL_STUDENT_EXAMS', PREFIX.'exams/student/exams/');
define('URL_STUDENT_QUIZ_GETLIST', PREFIX.'exams/student/quiz/getList/');
define('URL_STUDENT_QUIZ_GETLIST_ALL', PREFIX.'exams/student/quiz/getList/all');
define('URL_STUDENT_TAKE_EXAM', PREFIX.'exams/student/quiz/take-exam/');
define('URL_STUDENT_EXAM_GETATTEMPTS', PREFIX.'exams/student/get-exam-attempts/');
define('URL_STUDENT_EXAM_ANALYSIS_BYSUBJECT', PREFIX.'student/analysis/by-subject/');
define('URL_STUDENT_EXAM_ANALYSIS_BYEXAM', PREFIX.'student/analysis/get-by-exam/');
define('URL_STUDENT_EXAM_FINISH_EXAM', PREFIX.'exams/student/finish-exam/');

define('URL_QUIZ_GET_SCHEDULED_EXAMS', PREFIX.'exams/student/get-scheduled-exams/');
define('URL_QUIZ_LOAD_SCHEDULED_EXAMS', PREFIX.'exams/student/load-scheduled-exams/');


//PARENT NAVIGATION
define('URL_PARENT_CHILDREN', PREFIX.'parent/children');
define('URL_PARENT_CHILDREN_LIST', PREFIX.'parent/children_list');
define('URL_PARENT_CHILDREN_GETLIST', PREFIX.'parent/children/getList/');
define('URL_SUBSCRIBE', PREFIX.'subscription/subscribe/');
define('URL_PARENT_ANALYSIS_FOR_STUDENTS', PREFIX.'children/analysis');

//STUDENT BOOKMARKS
define('URL_BOOKMARKS', PREFIX.'student/bookmarks/');
define('URL_BOOKMARK_ADD', PREFIX.'student/bookmarks/add');
define('URL_BOOKMARK_DELETE', PREFIX.'student/bookmarks/delete/');
define('URL_BOOKMARK_DELETE_BY_ID', PREFIX.'student/bookmarks/delete_id/');
define('URL_BOOKMARK_AJAXLIST', PREFIX.'student/bookmarks/getList/');
define('URL_BOOKMARK_SAVED_BOOKMARKS', PREFIX.'student/bookmarks/getSavedList');


//EXAM SERIES
define('URL_EXAM_SERIES', PREFIX.'exams/exam-series');
define('URL_EXAM_SERIES_ADD', PREFIX.'exams/exam-series/add');
define('URL_EXAM_SERIES_DELETE', PREFIX.'exams/exam-series/delete/');
define('URL_EXAM_SERIES_EDIT', PREFIX.'exams/exam-series/edit/');
define('URL_EXAM_SERIES_AJAXLIST', PREFIX.'exams/exam-series/getList');
define('URL_EXAM_SERIES_UPDATE_SERIES', PREFIX.'exams/exam-series/update-series/');
define('URL_EXAM_SERIES_GET_EXAMS', PREFIX.'exams/exam-series/get-exams');


define('URL_STUDENT_EXAM_SERIES_LIST', PREFIX.'exams/student-exam-series/list');
define('URL_STUDENT_EXAM_SERIES_VIEW_ITEM', PREFIX.'exams/student-exam-series/');



define('URL_PAYMENTS_CHECKOUT', PREFIX.'payments/checkout/');


define('URL_PAYMENTS_LIST', PREFIX.'payments/list/');
define('URL_PAYNOW', PREFIX.'payments/paynow/');
define('URL_PAYPAL_PAYMENT_SUCCESS', PREFIX.'payments/paypal/status-success');
define('URL_PAYPAL_PAYMENT_CANCEL', PREFIX.'payments/paypal/status-cancel');

define('URL_PAYPAL_PAYMENTS_AJAXLIST', PREFIX.'payments/getList/');

define('URL_PAYU_PAYMENT_SUCCESS', PREFIX.'payments/payu/status-success');
define('URL_PAYU_PAYMENT_CANCEL', PREFIX.'payments/payu/status-cancel');
define('URL_UPDATE_OFFLINE_PAYMENT', PREFIX.'payments/offline-payment/update');

//COUPONS MODULE
define('URL_COUPONS', PREFIX.'coupons/list');
define('URL_COUPONS_ADD', PREFIX.'coupons/add');
define('URL_COUPONS_EDIT', PREFIX.'coupons/edit/');
define('URL_COUPONS_DELETE', PREFIX.'coupons/delete/');
define('URL_COUPONS_GETLIST', PREFIX.'coupons/getList');

define('URL_COUPONS_VALIDATE', PREFIX.'coupons/validate-coupon');
define('URL_COUPONS_USAGE', PREFIX.'coupons/get-usage');
define('URL_COUPONS_USAGE_AJAXDATA', PREFIX.'coupons/get-usage-data');



// Notifications Module
define('URL_ADMIN_NOTIFICATIONS', PREFIX.'admin/notifications');
define('URL_ADMIN_NOTIFICATIONS_ADD', PREFIX.'admin/notifications/add');
define('URL_ADMIN_NOTIFICATIONS_EDIT', PREFIX.'admin/notifications/edit/');
define('URL_ADMIN_NOTIFICATIONS_DELETE', PREFIX.'admin/notifications/delete/');
define('URL_ADMIN_NOTIFICATIONS_GETLIST', PREFIX.'admin/notifications/getList');

//Notifications Student
define('URL_NOTIFICATIONS', PREFIX.'notifications/list');
define('URL_NOTIFICATIONS_VIEW', PREFIX.'notifications/show/');




//LMS MODULE
define('URL_LMS_CATEGORIES', PREFIX.'lms/categories');
define('URL_LMS_CATEGORIES_ADD', PREFIX.'lms/categories/add');
define('URL_LMS_CATEGORIES_EDIT', PREFIX.'lms/categories/edit/');
define('URL_LMS_CATEGORIES_DELETE', PREFIX.'lms/categories/delete/');
define('URL_LMS_CATEGORIES_GETLIST', PREFIX.'lms/categories/getList');

// LMS CONTENT
define('URL_LMS_CONTENT', PREFIX.'lms/content');
define('URL_LMS_CONTENT_ADD', PREFIX.'lms/content/add');
define('URL_LMS_CONTENT_EDIT', PREFIX.'lms/content/edit/');
define('URL_LMS_CONTENT_DELETE', PREFIX.'lms/content/delete/');
define('URL_LMS_CONTENT_GETLIST', PREFIX.'lms/content/getList');


//LMS SERIES
define('URL_LMS_SERIES', PREFIX.'lms/series');
define('URL_LMS_SERIES_ADD', PREFIX.'lms/series/add');
define('URL_LMS_SERIES_DELETE', PREFIX.'lms/series/delete/');
define('URL_LMS_SERIES_EDIT', PREFIX.'lms/series/edit/');
define('URL_LMS_SERIES_AJAXLIST', PREFIX.'lms/series/getList');
define('URL_LMS_SERIES_UPDATE_SERIES', PREFIX.'lms/series/update-series/');
define('URL_LMS_SERIES_GET_SERIES', PREFIX.'lms/series/get-series');


//LMS STUDENT SERIES
define('URL_STUDENT_LMS_CATEGORIES', PREFIX.'learning-management/categories');
define('URL_STUDENT_LMS_CATEGORIES_VIEW', PREFIX.'learning-management/view/');
define('URL_STUDENT_LMS_SERIES', PREFIX.'learning-management/series');
define('URL_STUDENT_LMS_SERIES_VIEW', PREFIX.'learning-management/series/');
define('VALID_IS_PAID_TYPE', PREFIX.'user/paid/');



//Results Constants
define('URL_RESULTS_VIEW_ANSWERS', PREFIX.'student/exam/answers/');

 define('URL_COMPARE_WITH_TOPER', PREFIX.'toppers/compare-with-topper/');

// FEEDBACK SYSTEM
define('URL_FEEDBACK_SEND', PREFIX.'feedback/send');
define('URL_FEEDBACKS', PREFIX.'feedback/list');
define('URL_FEEDBACK_VIEW', PREFIX.'feedback/view-details/');
define('URL_FEEDBACK_DELETE', PREFIX.'feedback/delete/');
define('URL_FEEDBACKS_GETLIST', PREFIX.'feedback/getlist');

//MESSAGES
define('URL_MESSAGES', PREFIX.'messages');
define('URL_MESSAGES_SHOW', PREFIX.'messages/');
define('URL_MESSAGES_CREATE', PREFIX.'messages/create');


define('URL_GENERATE_CERTIFICATE', PREFIX.'result/generate-certificate/');


define('URL_PAYMENT_REPORTS', PREFIX.'payments-report/');
define('URL_ONLINE_PAYMENT_REPORTS', PREFIX.'payments-report/online');
define('URL_ONLINE_PAYMENT_REPORT_DETAILS', PREFIX.'payments-report/online/');
define('URL_ONLINE_PAYMENT_REPORT_DETAILS_AJAX', PREFIX.'payments-report/online/getList/');
define('URL_OFFLINE_PAYMENT_REPORTS', PREFIX.'payments-report/offline');
define('URL_OFFLINE_PAYMENT_REPORT_DETAILS', PREFIX.'payments-report/offline/');
define('URL_OFFLINE_PAYMENT_REPORT_DETAILS_AJAX', PREFIX.'payments-report/offline/getList/');

define('URL_PAYMENT_REPORT_EXPORT', PREFIX.'payments-report/export');
define('URL_GET_PAYMENT_RECORD', PREFIX.'payments-report/getRecord');
define('URL_PAYMENT_APPROVE_OFFLINE_PAYMENT', PREFIX.'payments/approve-reject-offline-request');


define('URL_SEND_SMS', PREFIX.'sms/index');
define('URL_SEND_SMS_NOW', PREFIX.'sms/send');

define('URL_FACEBOOK_LOGIN', PREFIX.'auth/facebook');
define('URL_GOOGLE_LOGIN', PREFIX.'auth/google');


//////////////////////////LIBRARY MODULE////////////////////////


//LIBRARY DASHBOARD
define('URL_LIBRARY_LIBRARYDASHBOARD', PREFIX.'library/librarydashboard');
define('URL_LIBRARY_LIBRARYDASHBOARD_BOOKS', PREFIX.'library/librarydashboard/books');
define('URL_LIBRARY_LIBRARYDASHBOARD_BOOKS_STAFF', PREFIX.'library/librarydashboard/books/staffbooks');
define('URL_LIBRARY_LIBRARYDASHBOARD_GETLIST', PREFIX.'library/librarydashboard/getList');
define('URL_LIBRARY_LIBRARYDASHBOARD_GETLIST_STAFF', PREFIX.'library/librarydashboard/getList/staff');


 
 //LIBRARY ASSETS
define('URL_LIBRARY_ASSETS', PREFIX.'library/assets');
define('URL_LIBRARY_ASSETS_ADD', PREFIX.'library/assets/add');
define('URL_LIBRARY_ASSETS_EDIT', PREFIX.'library/assets/edit/');
define('URL_LIBRARY_ASSETS_DELETE', PREFIX.'library/assets/delete/');
define('URL_LIBRARY_ASSETS_GETLIST', PREFIX.'library/assets/getList');

//LIBRARY ASSETS
define('URL_LIBRARY_MASTERS', PREFIX.'library/master');
define('URL_LIBRARY_MASTERS_SHOW', PREFIX.'library/master/view/');
define('URL_LIBRARY_MASTERS_ADD', PREFIX.'library/master/add');
define('URL_LIBRARY_MASTERS_EDIT', PREFIX.'library/master/edit/');
define('URL_LIBRARY_MASTERS_DELETE', PREFIX.'library/master/delete/');
define('URL_LIBRARY_ASSET_DETAILS', PREFIX.'library/master/details/');
define('URL_PRINT_LIBRAY_ASSET_DETAILS', PREFIX.'library/master/details/print/');
define('URL_LIBRARY_MASTERS_GETLIST', PREFIX.'library/master/getList');
define('URL_LIBRARY_MASTERS_COLLECTIONS_DELETE', PREFIX.'library/master/collections/delete/');


//LIBRARY COLLECTIONS
define('URL_LIBRARY_COLLECTIONS', PREFIX.'library/master/collections/');
define('URL_LIBRARY_COLLECTIONS_ADD_BULK', PREFIX.'library/master/add-bulk/');
define('URL_LIBRARY_COLLECTIONS_STATUS', PREFIX.'library/master/change-status');
define('URL_LIBRARY_COLLECTIONS_BARCODE', PREFIX.'library/master/collections/barcode/');
define('URL_LIBRARY_COLLECTIONS_ADD', PREFIX.'library/master/collections/add/');
define('URL_LIBRARY_COLLECTIONS_EDIT', PREFIX.'library/master/collections/edit/');
define('URL_LIBRARY_COLLECTIONS_LIST', PREFIX.'library/master/get-collection-list/');


//AUTHORS
define('URL_AUTHORS', PREFIX.'library/authors');
define('URL_AUTHORS_ADD', PREFIX.'library/authors/add');
define('URL_AUTHORS_EDIT', PREFIX.'library/authors/edit/');
define('URL_AUTHORS_DELETE', PREFIX.'library/authors/delete/');
define('URL_AUTHORS_GETLIST', PREFIX.'library/authors/getList');

//PUBLISHERS
define('URL_PUBLISHERS', PREFIX.'library/publishers');
define('URL_PUBLISHERS_ADD', PREFIX.'library/publishers/add');
define('URL_PUBLISHERS_EDIT', PREFIX.'library/publishers/edit/');
define('URL_PUBLISHERS_DELETE', PREFIX.'library/publishers/delete/');
define('URL_PUBLISHERS_GETLIST', PREFIX.'library/publishers/getList');

//Library Issues
define('URL_LIBRARY_USERS', PREFIX.'library/users/');
define('URL_LIBRARY_USERS_GETLIST', PREFIX.'library/getUsersList/');
define('URL_LIBRARY_ISSUES', PREFIX.'library/issue/');
define('URL_LIBRARY_ISSUES_GET_REFERENCE', PREFIX.'library/issues/get-reference');
define('URL_LIBRARY_ISSUES_GET_REFERENCE_STAFF', PREFIX.'library/issues/get-reference/staff');
define('URL_LIBRARY_ISSUES_GET_MASTER_DETAILS', PREFIX.'library/issues/get-master-details');
define('URL_LIBRARY_ISSUE_ASSET', PREFIX.'library/issues/issue-asset');
define('URL_LIBRARY_RETURN_ASSET', PREFIX.'library/returns/return-asset');
define('URL_LIBRARY_RETURN_ASSET_STAFF', PREFIX.'library/returns/return-asset/staff');


//STUDENT ATTENDENCE MODULE

define('URL_STUDENT_ATTENDENCE', PREFIX.'student/attendance/');
define('URL_STUDENT_ATTENDENCE_ADD', PREFIX.'student/attendance/add/');
define('URL_STUDENT_ATTENDENCE_UPDATE', PREFIX.'student/attendance/update/');
define('URL_STUDENT_ATTENDENCE_EDIT', PREFIX.'student/attendance/edit/');
define('URL_STUDENT_ATTENDENCE_DELETE', PREFIX.'student/attendance/delete/');
define('URL_STUDENT_ATTENDENCE_GETLIST', PREFIX.'student/attendance/getlist/');


//STUDENT ATTENDENCE REPORT
define('URL_STUDENT_ATTENDENCE_REPORT', PREFIX.'student/attendance/reports');
define('URL_STUDENT_ATTENDENCE_SUMMARY', PREFIX.'student/attendance/reports/get-attendance');
define('URL_STUDENT_ATTENDENCE_SUMMARY_COUNT', PREFIX.'student/attendance/reports/count-attendance');

define('URL_STUDENT_CLASS_ATTENDANCE', PREFIX.'student/class-attendance');
define('URL_STUDENT_ATTENDANCE_LESSIONPLAN', PREFIX.'lessionplan/by-attendance');
define('URL_PRINT_CLASS_ATTENDANCE_REPORT', PREFIX.'student/class-attendance/print');

//STUDENT MARKS REPORTS
define('URL_STUDENT_MARKS_REPORT', PREFIX.'student/class-marks');
define('URL_STUDENT_CLASS_OFFLINE_EXAMS_LIST', PREFIX.'student/class-offline-exams-list');
define('URL_STUDENT_CLASS_MARKS', PREFIX.'student/class-marks');
define('URL_PRINT_CLASS_OFFLINE_MARKS_REPORT', PREFIX.'student/class-marks/offline-exams/print');

//STUDENT LIST ACCORDING TO THE CLASS

define('URL_STUDENT_LIST', PREFIX.'student/list');
define('URL_PRINT_STUDENT_LIST_CLASSWISE', PREFIX.'student/list/classwise/print');
define('URL_STUDENT_COMPLETED_LIST', PREFIX.'student/completed/list');
define('URL_PRINT_COURSE_COMPLETED_STUDENT_LIST', PREFIX.'student/completed/list/print');
define('URL_STUDENT_DETAINED_LIST', PREFIX.'student/detained/list');
define('URL_PRINT_DETAINED_STUDENT_LIST', PREFIX.'student/detained/list/print');
// define('URL_STUDENT_CLASS_OFFLINE_EXAMS_LIST', PREFIX.'student/class-offline-exams-list');
// define('URL_STUDENT_CLASS_MARKS', PREFIX.'student/class-marks');

//LESSION PLANS MODULE
define('URL_LESSION_PLANS_DASHBOARD', PREFIX.'staff/lession-plans/');
define('URL_LESSION_PLANS_VIEW_TOPICS', PREFIX.'staff/lession-plans/view-topics/');
define('URL_LESSION_PLANS_UPDATE_TOPIC', PREFIX.'staff/lession-plans/update-topic');
define('URL_LESSION_PLANS_GET_LASTUPDATED_RECORDS', PREFIX.'staff/lession-plans/get-last-updated-records');

define('URL_LESSION_PLANS_STUDENTLIST_DASHBOARD', PREFIX.'staff/lession-plans/student-list/');
define('URL_LESSION_PLANS_VIEW_STUDENTS', PREFIX.'staff/lession-plans/view-students');
define('URL_LESSION_PLANS_VIEW_STUDENTS_GETLIST', PREFIX.'staff/lession-plans/view-students/get-list/');



//STUDENT RESULTS CONSTANTS
define('URL_STUDENT_RESULTS', PREFIX.'student/results/');
define('URL_STUDENT_RESULTS_GET_EXAM_CATEGORIES', PREFIX.'student/results/get-exam-categories');
define('URL_STUDENT_RESULTS_GET_EXAMS', PREFIX.'student/results/get-exams');

//STUDENT TRANSFERS CONSTANTS
define('URL_STUDENT_TRANSFERS', PREFIX.'student/transfers');
define('URL_STUDENT_TRANSFER_SINGLE_STUDENT', PREFIX.'student/transfer-single-student');

//SEARCH STUDENTS
define('URL_STUDENT_SEARCH', PREFIX.'student/search');
define('URL_CHECK_CERTIFICATE_ISSUED', PREFIX.'certificate-issues/is-issued');
define('URL_ISSUE_CERTIFICATE', PREFIX.'certificate/issue');
define('URL_ISSUE_CERTIFICATE_TC_DETAILS', PREFIX.'certificate/issue/tc');

//STUDENT MARKS MODULE
define('URL_OFFLINE_MARKS_UPLOAD', PREFIX.'marks/upload');


//TRANSPORTATION VEHICLES
define('URL_TRANSPORTATION_VEHICLES', PREFIX.'transportation/vehicles');
define('URL_TRANSPORTATION_VEHICLES_ADD', PREFIX.'transportation/vehicles/add');
define('URL_TRANSPORTATION_VEHICLES_EDIT', PREFIX.'transportation/vehicles/edit/');
define('URL_TRANSPORTATION_VEHICLES_DELETE', PREFIX.'transportation/vehicles/delete/');
define('URL_TRANSPORTATION_VEHICLES_GETLIST', PREFIX.'transportation/vehicles/getlist');


//TRANSPORTATION VEHICLES TYPES

define('URL_TRANSPORTATION_VEHICLES_TYPES', PREFIX.'transportation/vehicles/types');
define('URL_TRANSPORTATION_VEHICLES_TYPES_ADD', PREFIX.'transportation/vehicles/types/add');
define('URL_TRANSPORTATION_VEHICLES_TYPES_EDIT', PREFIX.'transportation/vehicles/types/edit/');
define('URL_TRANSPORTATION_VEHICLES_TYPES_DELETE', PREFIX.'transportation/vehicles/types/delete/');
 define('URL_TRANSPORTATION_VEHICLES_TYPES_GETLIST', PREFIX.'transportation/vehicles/types/getlist');



//OFFLINE EXAMS

define('URL_OFFLINE_EXAMS', PREFIX.'academicoperations/offline-exams');
define('URL_OFFLINE_EXAMS_SELECTION_VIEW', PREFIX.'academicoperations/offline-exams/exams/');
define('URL_OFFLINE_EXAMS_GETLIST', PREFIX.'academicoperations/offline-exams/getlist');
define('URL_OFFLINE_EXAMS_ADD', PREFIX.'academicoperations/offline-exams/add');
define('URL_OFFLINE_EXAMS_UPDATE', PREFIX.'academicoperations/offline-exams/store');
define('URL_OFFLINE_EXAMS_DELETE', PREFIX.'academicoperations/offline-exams/delete/');

define('URL_OFFLINE_EXAMS_IMPORT_MARKS', PREFIX.'academicoperations/offline-exams/import-excel');
define('URL_OFFLINE_EXAMS_GET_INFORMATION', PREFIX.'academicoperations/offline-exams/get-information');



//TIMETABLE TIMINGS SET
define('URL_TIMETABLE_DASHBOARD', PREFIX.'timetable');

define('URL_TIMINGSET', PREFIX.'timetable/timing-set');
define('URL_TIMINGSET_EDIT', PREFIX.'timetable/timing-set/edit');
define('URL_TIMINGSET_ADD', PREFIX.'timetable/timing-set/add');
define('URL_TIMINGSET_DELETE', PREFIX.'timetable/timing-set/delete/');
define('URL_TIMINGSET_RECORD_DELETE', PREFIX.'timetable/timing-set/delete-timingset-record/');


//TIMETABLE MAPTIMINGSET
define('URL_MAP_TIMINGSET', PREFIX.'timetable/map-timingset/');
define('URL_MAP_TIMINGSET_ADD', PREFIX.'timetable/map-timingset/add/');

define('URL_TIMETABLE_VIEW', PREFIX.'timetable/allot-timetable');

//TIMETABLE MAPTIMINGSET PARENT
define('URL_MAP_TIMINGSET_PARENT', PREFIX.'maptimingset/parent');
define('URL_MAP_TIMINGSET_PARENT_ADD', PREFIX.'maptimingset/parent/add');
define('URL_MAP_TIMINGSET_PARENT_EDIT', PREFIX.'maptimingset/parent/edit/');
define('URL_MAP_TIMINGSET_PARENT_DELETE', PREFIX.'maptimingset/parent/delete/');
define('URL_MAP_TIMINGSET_PARENT_AJAXLIST', PREFIX.'maptimingset/parent/getList');


// define('URL_TIMETABLE_VIEW', PREFIX.'timetable/allot-timetable');
define('URL_GET_TIMETABLE_DETAILS', PREFIX.'timetable/get-timetable-details');
define('URL_UPDATE_TIMETABLE', PREFIX.'timetable/update-timetable');
define('URL_TIMETABLE_IS_STAFF_AVAILABLE', PREFIX.'timetable/is-available');
define('URL_TIMETABLE_STAFF', PREFIX.'timetable/user/');
define('URL_TIMETABLE_PRINT', PREFIX.'timetable/print');
define('URL_TIMETABLE_STAFF_STUDENT_PRINT', PREFIX.'timetable/print/');


//Dashboards -academic operations
define('URL_ACADEMICOPERATIONS_DASHBOARD', PREFIX.'academicoperations/dashboard');

//Dashboards -users
define('URL_USERS_DASHBOARD', PREFIX.'users/dashboard');

//Dashboards -exams
define('URL_EXAMS_DASHBOARD', PREFIX.'exams/dashboard');

//Dashboards -lms
define('URL_LMS_DASHBOARD', PREFIX.'lms/dashboard');

//Dashboards -settings
define('URL_SETTINGS_DASHBOARD', PREFIX.'settings/dashboard');

//Dashboards -courses
define('URL_COURSES_DASHBOARD', PREFIX.'courses/dashboard');

define('URL_HEADER_SEARCH_LINK', PREFIX.'user/search');

//Student Quiz Dashboard
define('URL_STUDENT_QUIZ_DASHBOARD', PREFIX.'student/quiz/dashboard');

define('URL_PRINT_HTMLDATA', PREFIX.'html/print-data');
