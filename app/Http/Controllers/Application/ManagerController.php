<?php

namespace App\Http\Controllers\Application;

// use Illuminate\Http\Request;

class ManagerController extends Controller
{
  /**
   * Undocumented variable
   *
   * @var string
   */
  protected $view = 'applications';

  /**
   * Undocumented variable
   *
   * @var string
   */
  protected $redirectTo = 'applications';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
    $this->middleware('manager');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $model = $this->appModelName;
    $applications = $model::where('marked', 0)
      ->join('users', 'applications.user_id', '=', 'users.id')
      ->select('applications.*', 'users.name', 'users.email')
      ->get();

    return view($this->view)->with(['applications' => $applications, 'header' => 'Заявки']);
  }

  /**
   * Undocumented function
   *
   * @param integer $application
   * @return void
   */
  public function mark($id)
  {
    $model = $this->appModelName;
    $application = $model::find($id);
    // dump($application);
    $application->marked = 1;
    $application->save();

    return redirect($this->redirectTo);
  }
}
