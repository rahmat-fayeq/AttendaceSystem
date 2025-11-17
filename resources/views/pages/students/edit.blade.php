@extends('layout.index')

@section('content')
    <div class="container p-5">
        <div class="flex justify-center">
            <div class="card card-border bg-base-100 w-full md:w-96 mt-5">
                <div class="card-body space-y-4">
                    <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="form-control">
                            <label class="label"><span class="label-text">{{ __('app.device_user_id') }}</span></label>
                            <input type="number" name="device_user_id" class="input input-bordered w-full"
                                value="{{ $student->device_user_id }}">
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">{{ __('app.name') }}</span></label>
                            <input type="text" name="name" class="input input-bordered w-full"
                                value="{{ $student->name }}" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">{{ __('app.father_name') }}</span></label>
                            <input type="text" name="father_name" class="input input-bordered w-full"
                                value="{{ $student->father_name }}" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">{{ __('app.department') }}</span></label>
                            <input type="text" name="department" class="input input-bordered w-full"
                                value="{{ $student->department }}" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">{{ __('app.phone') }}</span></label>
                            <input type="number" name="phone_number" class="input input-bordered w-full"
                                value="{{ $student->phone_number }}">
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">{{ __('app.email') }}</span></label>
                            <input type="email" name="email" class="input input-bordered w-full"
                                value="{{ $student->email }}">
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary w-full">{{ __('app.save') }}</button>
                            <a href="{{ route('students.index') }}"
                                class="btn btn-secondary w-full mt-2">{{ __('app.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
