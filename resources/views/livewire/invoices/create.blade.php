<section class="app my-3">
    <div class="container-fluid">
        <div class="row g-3 cards hide-print ">
            <div class="col-xl-2 special-col">
                <div class="card-app">
                    <div class="title-card-app">
                        {{-- الأصناف الرئيسية --}}
                        {{-- <label for="">
                            <input type="checkbox" id=""> Category
                        </label> --}}
                        <div for="" class="d-flex align-items-center text-nowrap gap-1">
                            الافسام 
                            <select class="form-control" wire:model="department_id">
                                <option value="">اختر </option>
                                @foreach ($departments as $depart)
                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="body-card-app">
                        <div class="nav flex-column nav-pills main-tap " id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            @foreach ($departments as $depart)
                            <button class="nav-link mb-2 {{ $depart->id == $department_id ? 'active' : '' }}"
                                type="button"
                                wire:click='$set("department_id",{{ $depart->id }})'>{{ $depart->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 special-medal-col">
                <div class="card-app ">
                    {{-- <div class="list-btn flex-wrap ">
                        <div class="btn btn-success btn-sm">
                            <i class="fa-solid fa-plus"></i>
                            اضافة جديد
                        </div>
                        <div class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i>
                            حفظ
                        </div>
                        <div class="btn btn-info text-white btn-sm">
                            <i class="fa-regular fa-floppy-disk"></i>
                            حفظ وطباعة
                        </div>
                        <div class="btn btn-danger btn-sm">
                            <i class="fa-regular fa-file-lines"></i>
                            تعليق الفاتورة
                        </div>
                        <div class="btn btn-warning text-white btn-sm">
                            <i class="fa-solid fa-print"></i>
                            طباعة
                        </div>
                        <div class="btn btn-secondary btn-sm">
                            <i class="fa-solid fa-eye"></i>
                            معاينة قبل الطباعة
                        </div>
                    </div> --}}
                    {{-- <div class="title-card-app text-start">
                        قائمة الأصناف الفرعية
                    </div> --}}
                    <div class="body-card-app content py-2 ">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="">
                                <div class="list-orders">
                                    @foreach ($products as $product)
                                     <div class="order-btn"
                                     wire:click='add_product({{ $product }})' >
                                     @if ($product->image)
                                        <img src="{{ asset('uploads/products/' . $product->image) }}"
                                            alt="{{ $product->name }}" class="img-thumbnail" width="100px">
                                    @else
                                        <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $product->name }}"
                                            class="img-thumbnail" width="100px">
                                    @endif
                                        <div>
                                            <span>{{ $product->name }}</span>
                                        </div>
                                     </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card-app">
                    <div class="mb-1 body-card-app pt-2">
                        <label for="" class="text-info">
                            اختيار فاتورة سابقة:
                        </label>
                        <select name="" class="form-select" id=""></select>
                    </div>
                    <div class="title-card-app text-start">
                        التفاصيل
                    </div>
                    <div class="body-card-app pt-2">
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                رقم الفاتورة:
                            </label>
                            <input type="number" name="" id="" class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                تاريخ الفاتورة:
                            </label>
                            <input type="date" name="" id="" class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                الدفع:
                            </label>
                            <select name="" class="form-select w-50" id=""></select>
                        </div>
                        <div class="d-flex align-items-center mb-3 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                الفواتير المعلقة:
                            </label>
                            <select name="" class="form-select w-50" id=""></select>
                        </div>
                    </div>
                    <div class="body-card-app">
                        <div class="table-responsive box-table ">
                            <table class="table">
                                <tr>
                                    <th>م</th>
                                    <th>اسم الصنف</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>الاجمالي</th>
                                    <th>حذف</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>سس</td>
                                    <td>سس</td>
                                    <td>سس</td>
                                    <td>سس</td>
                                    <td class="text-center">
                                        <div class="btn btn-sm btn-danger py-0 px-1">
                                            <i class="fas fa-trash-can"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="footer-table">
                                <div class="num">0.00</div>
                                <div class="num">0.00</div>
                                <div class="num">0.00</div>
                            </div>
                        </div>
                    </div>
                    <div class="title-card-app text-start mt-3">
                        الاجماليات
                    </div>
                    <div class="body-card-app pt-2">
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                مبلغ الفاتورة:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                الخصم:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                الاجمالي بعد الخصم:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-info">
                                الضريبة:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-danger">
                                الاجمالي النهائي:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control text-danger w-50">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
