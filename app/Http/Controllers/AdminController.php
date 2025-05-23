<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('users', json_encode($array));
    }

    public function profile()
    {
        $profile = Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Profil berhasil diubah');
        } else {
            request()->session()->flash('error', 'Error terjadi saat mengubah profil');
        }
        return redirect()->back();
    }

    public function settings()
    {
        $data = Settings::first();
        return view('backend.setting')->with('data', $data);
    }

    public function settingsUpdate(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'short_des' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required',
            'logo' => 'required',
            'coordinates' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);
        $data = $request->all();
        // return $data;
        $settings = Settings::first();
        // return $settings;
        $status = $settings->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Pengaturan Website Berhasil Diubah');
        } else {
            request()->session()->flash('error', 'Error terjadi saat mengubah pengaturan website');
        }
        return redirect()->route('admin');
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success', 'Berhasil mengubah password');
    }

    // Pie chart
    public function userPieChart(Request $request)
    {
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('course', json_encode($array));
    }

    // public function activity(){
    //     return Activity::all();
    //     $activity= Activity::all();
    //     return view('backend.layouts.activity')->with('activities',$activity);
    // }

    public function storageLink()
    {
        // check if the storage folder already linked;
        if (File::exists(public_path('storage'))) {
            // removed the existing symbolic link
            File::delete(public_path('storage'));

            //Regenerate the storage link folder
            try {
                Artisan::call('storage:link');
                request()->session()->flash('success', 'Berhasil menghubungkan storage.');
                return redirect()->back();
            } catch (\Exception $exception) {
                request()->session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        } else {
            try {
                Artisan::call('storage:link');
                request()->session()->flash('success', 'Berhasil menghubungkan storage.');
                return redirect()->back();
            } catch (\Exception $exception) {
                request()->session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
    }

    public function cartReport(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $report = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->join('orders', 'carts.order_id', '=', 'orders.id')
            ->select(
                'products.title as product_title',
                'products.id as product_id',
                DB::raw('SUM(carts.quantity) as total_quantity'),
                DB::raw('SUM(carts.price * carts.quantity) as total_amount'),
                DB::raw('COUNT(DISTINCT carts.order_id) as total_orders'),
                DB::raw('MAX(carts.created_at) as last_created_at')
            )
            ->where('orders.payment_status', 'paid');

        if ($month && $year) {
            $report->whereMonth('orders.created_at', $month)
                ->whereYear('orders.created_at', $year);
        } elseif ($month) {
            $report->whereMonth('orders.created_at', $month);
        } elseif ($year) {
            $report->whereYear('orders.created_at', $year);
        }

        $report = $report->groupBy('products.id', 'products.title')
            ->paginate(10);

        return view('backend.report.product', compact('report'));
    }

    public function cartReportPrint(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $setting = Settings::first();

        $report = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->join('orders', 'carts.order_id', '=', 'orders.id')
            ->select(
                'products.title as product_title',
                'products.id as product_id',
                DB::raw('SUM(carts.quantity) as total_quantity'),
                DB::raw('SUM(carts.price * carts.quantity) as total_amount'),
                DB::raw('COUNT(DISTINCT carts.order_id) as total_orders'),
                DB::raw('MAX(carts.created_at) as last_created_at')
            )
            ->where('orders.payment_status', 'paid');

        if ($month && $year) {
            $report->whereMonth('orders.created_at', $month)
                ->whereYear('orders.created_at', $year);
        } elseif ($month) {
            $report->whereMonth('orders.created_at', $month);
        } elseif ($year) {
            $report->whereYear('orders.created_at', $year);
        }

        $report = $report->groupBy('products.id', 'products.title')
            ->get();


        $pdf = Pdf::loadView('backend.report.product-pdf', compact('report', 'month', 'year', 'setting'));
        return $pdf->stream('laporan_penjualan_' . Carbon::createFromDate($year, $month, 1)->translatedFormat('F') . '_' . $year . '.pdf');
    }
}
