<!--begin::Row-->
<div class="row g-6 g-xl-9 mb-6 mb-xl-9">
    @forelse ($media as $item)
        @if ($item->mime_type == 'image/png' || $item->mime_type == 'image/jpeg' || $item->mime_type == 'image/jpg')
            <!--begin::Col-->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <!--begin::Card-->
                <div class="card h-100">
                    <!--begin::Card body-->
                    <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                        <!--begin::Name-->
                        <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                            <!--begin::Image-->
                            <div class="symbol symbol-60px mb-5">
                                <a href="{{ $item->original_url }}" target="__blank"><img src="{{ $item->original_url }}"
                                        alt="{{ $item->original_url }}" class="attachment-img" /></a>
                            </div>
                            <!--end::Image-->
                            <!--begin::Title-->
                            <div class="fs-5 fw-bolder mb-2">{{ Str::of($item->file_name)->limit(10,'***')->before('.').'.'.Str::of($item->file_name)->after('.')}}</div>
                            <!--end::Title-->
                        </a>
                        <!--end::Name-->
                        <!--begin::Description-->
                        {{-- <div class="fs-7 fw-bold text-gray-400">3 days ago</div> --}}
                        <!--end::Description-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        @endif

        @if ($item->mime_type == 'application/pdf')
            <!--begin::Col-->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <!--begin::Card-->
                <div class="card h-100">
                    <!--begin::Card body-->
                    <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                        <!--begin::Name-->
                        <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                            <!--begin::Image-->
                            <div class="symbol symbol-60px mb-5">
                                <a href="{{ $item->original_url }}" target="__blank"><img src="{{ asset('media/icons/pdf.svg') }}" alt="{{ $item->original_url }}" /></a>
                            </div>
                            <!--end::Image-->
                            <!--begin::Title-->
                            <div class="fs-5 fw-bolder mb-2">{{ Str::of($item->file_name)->limit(10,'***')->before('.').'.'.Str::of($item->file_name)->after('.')}}</div>
                            <!--end::Title-->
                        </a>
                        <!--end::Name-->
                        <!--begin::Description-->
                        {{-- <div class="fs-7 fw-bold text-gray-400">3 days ago</div> --}}
                        <!--end::Description-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        @else
            <!--begin::Col-->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <!--begin::Card-->
                <div class="card h-100">
                    <!--begin::Card body-->
                    <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                        <!--begin::Name-->
                        <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                            <!--begin::Image-->
                            <div class="symbol symbol-60px mb-5">
                                <a href="{{ $item->original_url }}" target="__blank"><img src="{{ asset('media/icons/doc.svg') }}"
                                        alt="{{ $item->original_url }}" /></a>
                            </div>
                            <!--end::Image-->
                            <!--begin::Title-->
                            <div class="fs-5 fw-bolder mb-2">{{ Str::of($item->file_name)->limit(10,'***')->before('.').'.'.Str::of($item->file_name)->after('.')}}</div>
                            <!--end::Title-->
                        </a>
                        <!--end::Name-->
                        <!--begin::Description-->
                        {{-- <div class="fs-7 fw-bold text-gray-400">3 days ago</div> --}}
                        <!--end::Description-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        @endif

    @empty
    @endforelse

</div>
<!--end:Row-->



