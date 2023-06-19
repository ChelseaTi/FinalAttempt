<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  /**
   * Logout the user
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function logout(Request $request)
  {
    Auth::logout();

    // Destroy session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }

  /**
   * Attempt to login the user
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function login(Request $request)
  {
    if (Auth::check()) {
      return redirect()->route('index')->withErrors([__("auth.already_authenticated")]);
    }

    $request = request()->validate([
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:8',
    ]);

    if (Auth::attempt($request, request('remember'))) {
      // Check linked employee status
      if (Auth()->user()->employee && Auth()->user()->employee->employment_status !== "active") {
        Auth::logout();

        return redirect()->back()->withErrors([__("auth.suspended")]);
      }

      return redirect()->route('index');
    }

    return redirect()->back()->withErrors([__("auth.failed")]);
  }

  /**
   * Display the login form
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Contracts\View\View
   */
  public function loginForm(Request $request)
  {
    if (Auth::check()) {
      return redirect()->route('index')->withErrors([__("auth.already_authenticated")]);
    }

    return view('auth.login');
  }

  /**
   * Validate the user password
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function passwordConfirm(Request $request)
  {
    if (!Auth::check()) {
      return redirect()->route('auth.login')->withErrors([__("auth.not_authenticated")]);
    }
    if (!Hash::check($request->password, $request->user()->password)) {
      return back()->withErrors([__("auth.password")]);
    }

    $request->session()->passwordConfirmed();

    return redirect()->intended();
  }

  /**
   * Display the password verification form
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Contracts\View\View
   */
  public function passwordForm(Request $request)
  {
    if (!Auth::check()) {
      return redirect()->route('auth.login')->withErrors([__("auth.not_authenticated")]);
    }

    return view('auth.password-confirm');
  }

  /**
   * Register the new user
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function register(Request $request)
  {
    $validated = request()->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
    ]);

    Auth::login($user);

    return redirect()->route('index');
  }

  /**
   * Display the registration form
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Contracts\View\View
   */
  public function registerForm(Request $request)
  {
    if (Auth::check()) {
      return redirect()->route('index')->withErrors([__("auth.already_authenticated")]);
    }

    return view('auth.register');
  }
}
