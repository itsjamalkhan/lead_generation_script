<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// LOGIN
$route['default_controller'] = 'loginController';
$route['login'] = 'loginController';
$route['registration'] = 'loginController/registration';
$route['logout'] = 'loginController/logout';
$route['login_validation'] = 'loginController/login_validation';


//Online Booking Form
$route['online-booking'] = 'bookingController/bookingView';
$route['booking-form'] = 'bookingController/addBooking';
$route['thank-you'] = 'bookingController/thankyouPage';
$route['booking-error'] = 'bookingController/bookingErrorPage';

$route['booking-record'] = 'bookingController/bookingRecord';
$route['booking-record/(:num)'] = 'bookingController/bookingRecord/$1';
$route['booking-details/(:any)'] = 'bookingController/bookingDetails/$1';



// PAGES

$route['dashboard'] = 'homeController/index';
$route['profile/(:any)'] = 'homeController/profile';



// USERS - staff
$route['users'] = 'userController/showUsers';
$route['users/(:num)'] = 'userController/showUsers/$1';
$route['add-user'] = 'userController/addUsers';
$route['edit-user'] = 'userController/editUser';
$route['update-user'] = 'userController/updateUser';
$route['delete-user/(:any)'] = 'userController/deleteUser/$1';

$route['staff-profile/(:any)'] = 'userController/staffProfileEdit';
$route['update-staff-picture'] = 'userController/update_staff_picture';
$route['reset-password/(:any)'] = 'userController/password_reset/$1';

$route['user-profile/(:any)'] = 'userController/singleUserDetails/$1';
$route['user-profile/(:any)/(:any)'] = 'userController/singleUserDetails/$1/$2';


// PROJECTS
$route['projects'] = 'projectController/showProjects';
$route['add-project'] = 'projectController/addProject';
$route['edit-project'] = 'projectController/editProject';
$route['update-project'] = 'projectController/updateProject';
$route['delete-project/(:any)'] = 'projectController/deleteProject/$1';

//----Payment Plan
$route['payment-plan'] = 'projectController/paymentPlan';
$route['add-payplan'] = 'projectController/addPaymentPlan';
$route['update-pplan'] = 'projectController/updatePaymentPlan';
$route['delete-payment-record/(:any)'] = 'projectController/deletePaymentPlan/$1';


$route['property-sizes'] = 'projectController/propertyType';
$route['delete-type/(:any)'] = 'projectController/deleteType/$1';





// LEADS
$route['leads'] = 'leadController/showLeads';
$route['leads/(:num)'] = 'leadController/showLeads/$1';
$route['add-lead'] = 'leadController/addLead';
$route['edit-lead/(:any)'] = 'leadController/editLead';
$route['update-lead'] = 'leadController/updateLead';
$route['delete-lead/(:any)'] = 'leadController/deleteLead/$1';

$route['another-booking'] = 'leadController/anotherBooking';

$route['notifications'] = 'notificationController/getNotifications';
$route['exportToCSV'] = 'leadController/exportCSV';

// REPORTS
$route['reports'] = 'reportController/showReports';
$route['reports/(:num)'] = 'reportController/showReports/$1';

$route['daily-report'] = 'reportController/dailyReports';
$route['daily-report/(:num)'] = 'reportController/dailyReports/$1';
$route['edit-reporting/(:any)'] = 'reportController/editdailyReports';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// API for Mobile

$route['api/login'] = 'APIController/login_validation';
$route['api/logout'] = 'APIController/logout';
