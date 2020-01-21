<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

use Gate;
use App\Mail\SendMailUser;
use App\User;
use App\Role;
use App\Company;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:users']);
    }

    public function index()
    {
        if (Gate::allows('migra')) {
            $users = User::search()->sortable('name')->paginate(config('config.paginate'));
        } else {
            $users = User::search()->sortable('name')->onlyCompany(Auth()->user()->company_id)
                    ->paginate(config('config.paginate'));
        }
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', new User);
        if (Gate::allows('migra')) {
            $companies = Company::all();
        } else {
            $companies = Company::onlyCompany(Auth::user()->company_id)->get();
        }
        $roles = Role::listUserPermission(Auth::user());
        return view('users.create', compact('companies', 'roles'));
    }

    public function store(Request $request)
    {

        $user = new User();
        $this->authorize('create', $user);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'company_id' => 'required|exists:companies,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $password = str_random(8);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->company_id = $request->company_id;
        $user->password = Hash::make($password);
        $user->save();
        $user->roles()->attach($request->role_id);

        /// @TODO Enviar e-mail com a senha.

        return redirect('users');
    }

    public function show($id)
    {
        $user = User::find($id);
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->authorize('update', $user);

        if (Gate::allows('root')) {
            $companies = Company::all();
        } else {
            $companies = Company::onlyCompany(Auth::user()->company_id)->get();
        }
        $roles = Role::listUserPermission(Auth::user());
        return view('users.edit', compact('user', 'roles', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->authorize('update', $user);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id.'|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->company_id = $request->company_id;
        $user->save();

        $user->roles()->sync($request->role_id, false);
        return redirect()->action('UserController@index');
    }

    public function remove($id)
    {
        
        try {
            $user = User::findOrFail($id);
            $this->authorize('delete', $user);
        } catch (QueryException  $e) {
            return redirect('users')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with("error", trans('message.no_record_found'));
        }

        return view('users.remove', compact('user'));
    }

    public function destroy($id)
    {
        
        try {
            $user = User::findOrFail($id);
            $this->authorize('delete', $user);
            $user->delete();
        } catch (QueryException  $e) {
            return redirect('users')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with("error", trans('message.no_record_found'));
        }
        return redirect('users');
    }

    public function editPassword()
    {
        return view('users.edit_password');
    }

    public function updatePassword(Request $request)
    {
        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            return redirect()->back()->with("error", __("auth.current_password_not_match"));
        }

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect()->back()->with('success', __('auth.password_changed_successfully'));
    }

    public function search(Request $request)
    {
        if ($q = $request->q) {
            $users = User::where('name', 'LIKE', '%' . $q . '%')->paginate(config('config.paginate'));
            if (count($users)) {
                return view('users.index', compact('users'));
            }
            return view('users.index', compact('users'))->withErrors('Sem resultados.');
        }
        return redirect('users');
    }
}
