@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-search">Cadastrar Novo Contrato</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.contracts.index') }}">Contratos</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.contracts.create') }}" class="text-orange">Cadastrar Contrato</a>
                        </li>
                    </ul>
                </nav>

                <button class="btn btn-green icon-search icon-notext ml-1 search_open"></button>
            </div>
        </header>

        @include('admin.contracts.filter')

        <div class="dash_content_app_box">

            <div class="nav">

                @if($errors->all())
                    @foreach($errors->all() as $error)
                        @component('admin.components.color-message', ['color' => 'orange'])
                            <p class="icon-asterisk">{{ $error }}</p>
                        @endcomponent
                    @endforeach
                @endif

                @if(session()->exists('message'))
                    @component('admin.components.color-message', ['color' => 'green'])
                        <p class="icon-asterisk">{{ session()->get('message') }}</p>
                    @endcomponent
                @endif

                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#parts" class="nav_tabs_item_link active">Das Partes</a>
                    </li>
                    <li class="nav_tabs_item">
                        <a href="#terms" class="nav_tabs_item_link">Termos</a>
                    </li>
                </ul>

                <div class="nav_tabs_content">
                    <div id="parts">
                        <form action="{{ route('admin.contracts.store') }}" method="post" class="app_form">
                            @csrf

                            <input type="hidden" name="owner_spouse_persist" value="{{ old('owner_spouse') }}">
                            <input type="hidden" name="owner_company_persist" value="{{ old('owner_company') }}">
                            <input type="hidden" name="acquirer_spouse_persist" value="{{ old('acquirer_spouse') }}">
                            <input type="hidden" name="acquirer_company_persist" value="{{ old('acquirer_company') }}">
                            <input type="hidden" name="property_persist" value="{{ old('property_id') }}">

                            <div class="label_gc">
                                <span class="legend">Finalidade:</span>
                                <label class="label">
                                    <input type="checkbox" name="sale" {{ old('sale') == 'on' ? 'checked' : '' }}><span>Venda</span>
                                </label>

                                <label class="label">
                                    <input type="checkbox" name="rent" {{ old('rent') == 'on' ? 'checked' : '' }}><span>Loca????o</span>
                                </label>
                            </div>

                            <label class="label">
                                <span class="legend">Status do Contrato:</span>
                                <select name="status" class="select2">
                                    <option value="pending" {{ old('status' === 'pending' ? 'select' : '') }}>Pendente
                                    </option>
                                    <option value="active" {{ old('status' === 'active' ? 'select' : '') }}>Ativo
                                    </option>
                                    <option value="canceled" {{ old('status' === 'canceled' ? 'select' : '') }}>
                                        Cancelado
                                    </option>
                                </select>
                            </label>

                            <div class="app_collapse">
                                <div class="app_collapse_header mt-2 collapse">
                                    <h3>Propriet??rio</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Propriet??rio:</span>
                                            <select class="select2" name="owner_id"
                                                    data-action="{{ route('admin.contracts.getDataOwner') }}">
                                                <option value="0">Informe um Cliente</option>
                                                @foreach($lessors->get() as $lessor)
                                                    <option value="{{ $lessor->id }}" {{ (old('owner_id') == $lessor->id ? 'selected' : '') }}>{{ $lessor->name }}
                                                        ({{ $lessor->document }})
                                                    </option>

                                                @endforeach
                                            </select>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Conjuge Propriet??rio:</span>
                                            <select class="select2" name="owner_spouse">
                                                <option value="" selected>N??o informado</option>
                                            </select>
                                        </label>
                                    </div>

                                    <label class="label">
                                        <span class="legend">Empresa:</span>
                                        <select class="select2" name="owner_company_id">
                                            <option value="" selected>N??o informado</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="app_collapse">
                                <div class="app_collapse_header mt-2 collapse">
                                    <h3>Adquirente</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Adquirente:</span>
                                            <select name="acquirer_id" class="select2"
                                                    data-action="{{ route('admin.contracts.getDataOwner') }}">
                                                <option value="0">Informe um Cliente</option>
                                                @foreach($lessees->get() as $lessee)
                                                    <option value="{{ $lessee->id }}" {{ (old('acquirer_id') == $lessee->id ? 'selected' : '') }}>{{ $lessee->name }}
                                                        ({{ $lessee->document }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Conjuge Adquirente:</span>
                                            <select class="select2" name="acquirer_spouse">
                                                <option value="" selected>N??o informado</option>
                                            </select>
                                        </label>
                                    </div>

                                    <label class="label">
                                        <span class="legend">Empresa:</span>
                                        <select name="acquirer_company_id" class="select2">
                                            <option value="" selected>N??o informado</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="app_collapse">
                                <div class="app_collapse_header mt-2 collapse">
                                    <h3>Par??metros do Contrato</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <label class="label">
                                        <span class="legend">Im??vel:</span>
                                        <select name="property_id" class="select2"
                                                data-action="{{ route('admin.contracts.getDataProperties') }}">
                                            <option value="">N??o informado</option>
                                        </select>
                                    </label>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Valor de Venda:</span>
                                            <input type="tel" name="sale_price" class="mask-money"
                                                   placeholder="Valor de Venda"
                                                   disabled {{ (old('sale') != 'on' ? 'disable' : '') }}/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Valor de Loca????o:</span>
                                            <input type="text" name="rent_price" class="mask-money"
                                                   placeholder="Valor de Loca????o"
                                                   disabled {{ (old('rent') != 'on' ? 'disable' : '') }}/>
                                        </label>
                                    </div>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">IPTU:</span>
                                            <input type="text" name="tribute" class="mask-money" placeholder="IPTU"
                                                   value=""/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Condom??nio:</span>
                                            <input type="text" name="condominium" class="mask-money"
                                                   placeholder="Valor do Condom??nio" value=""/>
                                        </label>
                                    </div>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Dia de Vencimento:</span>
                                            <select name="due_date" class="select2">
                                                @for($i = 1; $i <= 28; $i++)
                                                    <option value="{{ $i }}">{{ $i }}??/m??s</option>
                                                @endfor
                                            </select>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Prazo do Contrato (Em meses)</span>
                                            <select name="deadline" class="select2">
                                                <option value="12" {{ old('deadline') == 12 ? 'selected' : ''}}">12 meses
                                                </option>
                                                <option value="24" {{ old('deadline') == 24 ? 'selected' : ''}}">24 meses
                                                </option>
                                                <option value="36" {{ old('deadline') == 36 ? 'selected' : ''}}">36 meses
                                                </option>
                                                <option value="48" {{ old('deadline') == 48 ? 'selected' : ''}}">48 meses
                                                </option>
                                            </select>
                                        </label>
                                    </div>

                                    <label class="label">
                                        <span class="legend">Data de In??cio:</span>
                                        <input type="tel" name="start_at" class="mask-date" placeholder="Data de In??cio"
                                               value="{{ old('start_at') }}"/>
                                    </label>
                                </div>
                            </div>

                            <div class="text-right mt-2">
                                <button class="btn btn-large btn-green icon-check-square-o">Salvar Contrato</button>
                            </div>
                        </form>
                    </div>

                    <div id="terms" class="d-none">
                        <h3 class="mb-2">Termos</h3>

                        <textarea name="terms" cols="30" rows="10" class="mce"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>

        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function setFieldOwnerId(response) {
                // Spouse
                $('select[name="owner_spouse"]').html('');
                if (response.spouse) {
                    $('select[name="owner_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informar'
                    }));

                    $('select[name="owner_spouse"]').append($('<option>', {
                        value: 1,
                        text: response.spouse.spouse_name + '(' + response.spouse.spouse_document + ')'
                    }));
                } else {
                    $('select[name="owner_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informado'
                    }));
                }

                // Companies
                $('select[name="owner_company_id"]').html('');
                if (response.companies != null && response.companies.length) {
                    $('select[name="owner_company_id"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informar'
                    }));

                    $.each(response.companies, function (key, value) {
                        $('select[name="owner_company_id"]').append($('<option>', {
                            value: value.id,
                            text: value.alias_name + '(' + value.document_company + ')'
                        }));
                    });

                } else {
                    $('select[name="owner_company_id"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informado'
                    }));
                }

                // Properties
                $('select[name="property_id"]').html('');
                if (response.properties != null && response.properties.length) {
                    $('select[name="property_id"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informar'
                    }));

                    $.each(response.properties, function (key, value) {
                        $('select[name="property_id"]').append($('<option>', {
                            value: value.id,
                            text: value.description
                        }));
                    });

                } else {
                    $('select[name="property_id"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informado'
                    }));
                }
            }

            function setFieldAcquirerId(response) {
                // Spouse
                $('select[name="acquirer_spouse"]').html('');
                if (response.spouse) {
                    $('select[name="acquirer_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informar'
                    }));

                    $('select[name="acquirer_spouse"]').append($('<option>', {
                        value: 1,
                        text: response.spouse.spouse_name + '(' + response.spouse.spouse_document + ')',
                        selected: ($('input[name="acquirer_spouse_persist"]').val() != 0 ? 'selected' : false)
                    }));
                } else {
                    $('select[name="acquirer_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informado'
                    }));
                }

                // Companies
                $('select[name="acquirer_company_id"]').html('');
                if (response.companies != null && response.companies.length) {
                    $('select[name="acquirer_company_id"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informar'
                    }));

                    $.each(response.companies, function (key, value) {
                        $('select[name="acquirer_company_id"]').append($('<option>', {
                            value: value.id,
                            text: value.alias_name + '(' + value.document_company + ')'
                        }));
                    });

                } else {
                    $('select[name="acquirer_company_id"]').append($('<option>', {
                        value: 0,
                        text: 'N??o informado'
                    }));
                }
            }

            function setFieldProperty(response) {
                if (response.property != null) {
                    $('input[name="sale_price"]').val(response.property.sale_price);
                    $('input[name="rent_price"]').val(response.property.rent_price);
                    $('input[name="tribute"]').val(response.property.tribute);
                    $('input[name="condominium"]').val(response.property.condominium);
                } else {
                    $('input[name="sale_price"]').val('0,00');
                    $('input[name="rent_price"]').val('0,00');
                    $('input[name="tribute"]').val('0,00');
                    $('input[name="condominium"]').val('0,00');
                }
            }


            $('select[name="owner_id"]').change(function () {
                let owner_id = $(this);
                $.post(owner_id.data('action'), {user: owner_id.val()}, function (response) {
                    setFieldOwnerId(response);
                }, 'json');
            });

            if ($('select[name="owner_id"]').val() != 0) {
                let owner_id = $('select[name="owner_id"]');
                $.post(owner_id.data('action'), {user: owner_id.val()}, function (response) {
                    setFieldOwnerId(response);
                }, 'json');
            }

            $('select[name="acquirer_id"]').change(function () {
                let acquirer_id = $(this);
                $.post(acquirer_id.data('action'), {user: acquirer_id.val()}, function (response) {
                    setFieldAcquirerId(response)
                }, 'json');
            });

            if ($('select[name="acquirer_id"]').val() != 0) {
                let acquirer_id = $('select[name="acquirer_id"]');
                $.post(acquirer_id.data('action'), {user: acquirer_id.val()}, function (response) {
                    setFieldAcquirerId(response);
                }, 'json');
            }

            $('select[name="property_id"]').change(function () {
                let property_id = $(this);
                $.post(property_id.data('action'), {property: property_id.val()}, function (response) {
                    setFieldProperty(response);
                }, 'json');
            });

            if ($('input[name="property_persist"]').val() > 0) {
                let property_id = $('select[name="property_id"]');
                $.post(property_id.data('action'), {property: $('input[name="property_persist"]').val()}, function (response) {
                    setFieldProperty(response);
                }, 'json');
            }
        });
    </script>
@endsection
