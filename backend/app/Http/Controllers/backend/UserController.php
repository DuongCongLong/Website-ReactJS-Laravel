<?php


namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //frontend
    public function getUserInfo(Request $request)
    {
        // Lấy thông tin người dùng đang đăng nhập
        $user = $request->user();

        // Kiểm tra nếu không có user (chưa đăng nhập)
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Trả về thông tin người dùng
        // Bạn có thể tùy chỉnh các trường muốn trả về
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            
            // Nếu muốn thêm thông tin từ các mối quan hệ khác
            // 'profile' => $user->profile,
            // 'roles' => $user->roles,
        ]);
    }







    //backend
    public function index(Request $request)
{
    $query = User::query();  // Thay vì User::all()


    $list = $query->orderBy('created_at', 'DESC')->paginate(4); // Sử dụng phân trang

    return view("backend.user.index", compact('list'));
}




    public function create()
    {
        return view("backend.user.create");
    }

    public function store(StoreUserRequest $request)
    {
        // Mã hóa mật khẩu
        $hashedPassword = bcrypt($request->input('password'));
    
        // Tạo đối tượng người dùng mới
        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->gender = $request->input('gender');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->roles = $request->input('roles');
        $user->address = $request->input('address');
        $user->password = $hashedPassword;
        $user->status = $request->input('status');
    
        // Xử lý hình ảnh nếu có
        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::slug($request->input('name'), '-') . '.' . $exten;
                $request->file('image')->move(public_path('images/users'), $filename);
                $user->image = $filename;
            } else {
                return back()->with('error', 'Định dạng hình ảnh không hợp lệ!');
            }
        }
    
        // Lưu người dùng vào cơ sở dữ liệu
        $user->save();
    
        // Chuyển hướng và thông báo thành công
        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được thêm thành công!');
    }
    

    public function show(string $user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        if ($user == null) {
            return redirect()->route('admin.user.index');
        }

        return view("backend.user.show", compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('admin.user.index');
        }

        return view("backend.user.edit", compact('user'));
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('admin.user.index');
        }

        $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user_id, 'user_id')],
            'username' => ['required', 'max:255', Rule::unique('users', 'username')->ignore($user_id, 'user_id')],
            'password' => 'nullable|min:8', // Mật khẩu tối thiểu 8 ký tự nếu có
            // Các quy tắc xác thực khác
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->phone = $request->input('phone');
        $user->roles = $request->input('roles');
        $user->address = $request->input('address');
        $user->gender = $request->input('gender');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được cập nhật thành công.');
    }

    public function status(string $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('admin.user.index');
        }

        $user->status = ($user->status == 1) ? 2 : 1;
        $user->updated_at = now();
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Trạng thái người dùng đã được cập nhật.');
    }

    public function delete(string $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('admin.user.index');
        }

        $user->status = 0;
        $user->updated_at = now();
        $user->updated_by = Auth::id() ?? 1;
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được chuyển vào thùng rác.');
    }

    public function trash()
    {
        $list = User::where('status', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view("backend.user.trash", compact('list'));
    }

    public function restore(string $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('admin.user.index');
        }

        $user->status = 2;
        $user->updated_at = now();
        $user->updated_by = Auth::id() ?? 1;
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được khôi phục.');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('admin.user.index');
        }

        $user->delete();

        return redirect()->route('admin.user.trash')->with('success', 'Người dùng đã được xóa vĩnh viễn.');
    }
}
