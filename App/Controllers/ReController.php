<?php

namespace App\Controllers;
use App\Models\Contact;
class ReController extends Controller
{
  public function __construct()
  {
    if (!AUTHGUARD()->isUserLoggedIn()) {
    $messages = ['success' => 'Đăng ký thành công!'];
redirect('/login', ['messages' => $messages]);

    }

    parent::__construct();
  }

  public function index()
 {
 $this->sendPage('contacts/index', [
 'contacts' => AUTHGUARD()->user()?->contacts() ?? []
 ]);
 }

 public function create()
 {
 $this->sendPage('contacts/create', [
 'errors' => session_get_once('errors'),
 'old' => $this->getSavedFormValues()
 ]);
 }
 public function store()
 {
 $data = $this->filterContactData($_POST);
 $newContact = new Contact(PDO());
 $model_errors = $newContact->validate($data);
 if (empty($model_errors)) {
 $newContact->fill($data)->setUser(AUTHGUARD()->user())->save();

 $_SESSION['message'] = 'Thêm contact thành công!';

 redirect('/');
 }
// Lưu các giá trị của form vào $_SESSION['form']
$this->saveFormValues($_POST);
// Lưu các thông báo lỗi vào $_SESSION['errors']
redirect('/contacts/create', ['errors' => $model_errors]);
}
protected function filterContactData(array $data)
{
return [
'name' => $data['name'] ?? '',
'phone' => $data['phone'] ?? '',
'notes' => $data['notes'] ?? ''
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
 $data = $this->filterContactData($_POST);
 $model_errors = $contact->validate($data);
 if (empty($model_errors)) {
 $contact->fill($data);
 $contact->save();

 $_SESSION['message'] = 'Cập nhật contact thành công!'; 

 redirect('/');
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

 $_SESSION['message'] = 'Xóa contact thành công!';

 redirect('/');
 }
}
