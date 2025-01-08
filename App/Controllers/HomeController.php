<?php

namespace App\Controllers;

use App\Models\Contact;
use App\Models\User;

class HomeController extends Controller
{
  public function __construct()
  {
    if (!AUTHGUARD()->isUserLoggedIn()) {
      redirect('/login');
    }

    parent::__construct();
  }
  // Tìm kiếm
  public function indexsearch()
  {
    $search = $_GET['search'] ?? '';
    $contacts = AUTHGUARD()->user()?->contacts($search) ?? [];

    $this->sendPage('contacts/Trangchu', [
      'contacts' => $contacts,
      'search' => $search,
    ]);
  }

  public function sanphamsearch()
  {
    $search = $_GET['search'] ?? '';

    $contacts = AUTHGUARD()->user()?->contacts($search) ?? [];

    $this->sendPage('contacts/Sanpham', [
      'contacts' => $contacts,
      'search' => $search,
    ]);
  }

  public function index()
  {

    $this->sendPage('contacts/Trangchu', [
      'contacts' => AUTHGUARD()->user()?->contacts() ?? []
    ]);
  }

public function indexAmin()
{
    // Kiểm tra xem người dùng có role = 1 không
   
    if ( AUTHGUARD()->isAdmin()) {
        // Nếu role là 1, cho phép truy cập trang admin
        $this->sendPage('contacts/TrangchuAmin', [
            'contacts' => AUTHGUARD()->user()?->contacts() ?? []
        ]);
    } else {
        // Nếu không phải admin (role khác 1), chuyển hướng về trang khác hoặc thông báo lỗi
        $_SESSION['error_message'] = 'Bạn không có quyền truy cập trang này.';
        redirect('/home');  // Chuyển hướng về trang chính hoặc trang khác
    }
}


  public function sanpham()
  {
    $this->sendPage('contacts/Sanpham', [
      'contacts' => AUTHGUARD()->user()?->contacts() ?? []
    ]);
  }

  public function create()
  {
    if ( AUTHGUARD()->isAdmin()) {
      // Nếu role là 1, cho phép truy cập trang admin
      error_log("Create contact page is being called.");
    $this->sendPage('contacts/Themsanpham', [
      'errors' => session_get_once('errors'),
      'old' => $this->getSavedFormValues()
    ]);
  } else {
      // Nếu không phải admin (role khác 1), chuyển hướng về trang khác hoặc thông báo lỗi
      $_SESSION['error_message'] = 'Bạn không có quyền truy cập trang này.';
      redirect('/home');  // Chuyển hướng về trang chính hoặc trang khác
  }
   
  }

  public function store()
  {
    $data = $this->filterContactData($_POST);
    $newContact = new Contact(PDO());
    $model_errors = $newContact->validate($data);

    if (empty($model_errors)) {
      $upload_errors = $newContact->uploadImg($_FILES['img']);
      if (!empty($upload_errors)) {
        $model_errors = array_merge($model_errors, $upload_errors);
      }

      if (empty($model_errors)) {
        $newContact->fill($data)
          ->setUser(AUTHGUARD()->user())
          ->save();
        $_SESSION['success_message'] = 'Thêm mới thành công';
        redirect('/homeAmin');
      }
    }
    redirect('/contacts/add', ['errors' => $model_errors]);
  }


  protected function filterContactData(array $data)
  {
    return [
      'name' => $this->e($data['name'] ?? ''),
      'img' => $this->e($data['img'] ?? ''),
      'description' => $this->e($data['description'] ?? ''),
      'price' => $this->e($data['price'] ?? ''),
      'priceGoc' => $this->e($data['priceGoc'] ?? ''),
      'product_type' => $this->e($data['product_type'] ?? ''),
      'cpu' => $this->e($data['cpu'] ?? ''),
      'ram' => $this->e($data['ram'] ?? ''),
      'storage' => $this->e($data['storage'] ?? ''),
      'battery_capacity' => $this->e($data['battery_capacity'] ?? ''),
      'camera_resolution' => $this->e($data['camera_resolution'] ?? ''),
      'screen_size' => $this->e($data['screen_size'] ?? ''),
      'os' => $this->e($data['os'] ?? ''),
      'band' => $this->e($data['band'] ?? ''),
      'strap_material' => $this->e($data['strap_material'] ?? '')
    ];
  }

  public function edit($contactId)
  {
    $contact = AUTHGUARD()->user()->findContact($contactId);
    if (!$contact) {
      $this->sendNotFound();
    }
    $form_values = $this->getSavedFormValues();
    $data = [
      'errors' => session_get_once('errors'),
      'contact' => (!empty($form_values)) ?
        array_merge($form_values, ['id' => $contact->id]) :
        (array) $contact
    ];
    $this->sendPage('contacts/edit', $data);
  }

  public function update($contactId)
  {
    $contact = AUTHGUARD()->user()->findContact($contactId);
    if (!$contact) {
      $this->sendNotFound();
    }
    if ($this->isCsrfTokenValid($_POST['csrf_token'] ?? '')) {
      $_SESSION['errors'][] = 'Invalid CSRF token.';
      redirect('/contacts/edit/' . $contactId);
    }
    $data = $this->filterContactData($_POST);
    $model_errors = $contact->validate($data);
    if (empty($model_errors)) {
      $upload_errors = $contact->uploadImg($_FILES['img']);
      if (!empty($upload_errors)) {
        $model_errors = array_merge($model_errors, $upload_errors);
      }
      $contact->fill($data);
      $contact->save();
      $_SESSION['success_message'] = 'Cập nhật thành công';
      redirect('/homeAmin');
    }
    $this->saveFormValues($_POST);
    redirect('/contacts/edit/' . $contactId, [
      'errors' => $model_errors
    ]);
  }

  public function destroy($contactId)
  {
    $contact = AUTHGUARD()->user()->findContact($contactId);
    if (!$contact) {
      $this->sendNotFound();
    }
    $contact->delete();
    $contact->deleteProduct();
    $_SESSION['error_message'] = 'Xóa thành công';
    redirect('/homeAmin');
  }

  protected function e($message)
  {
    return htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
  }

  protected function isCsrfTokenValid($token)
  {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
  }
}
