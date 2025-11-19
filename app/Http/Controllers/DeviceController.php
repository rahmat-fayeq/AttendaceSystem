<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Devrabiul\ToastMagic\Facades\ToastMagic;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('pages.devices.index', compact('devices'));
    }

    public function create()
    {
        return view('pages.devices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'ip_address'  => 'required|ip|unique:devices,ip_address',
            'port'        => 'nullable|integer',
            'comm_key'    => 'nullable|integer',
            'is_active'   => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Device::create($validated);

        ToastMagic::success(__('app.add'));

        return redirect()->route('devices.index');
    }

    public function edit(Device $device)
    {
        return view('pages.devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'ip_address'  => 'required|ip|unique:devices,ip_address,' . $device->id,
            'port'        => 'nullable|integer',
            'comm_key'    => 'nullable|integer',
            'is_active'   => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $device->update($validated);

         ToastMagic::info(__('app.edit'));

        return redirect()->route('devices.index');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        ToastMagic::warning(__('app.delete'));
        return redirect()->route('devices.index');
    }
}
