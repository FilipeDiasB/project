@extends('admin.master.master')

@section('content')

    <div style="flex-basis: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Dashboard</h2>
            </header>

            <div class="dash_content_app_box">
                <section class="app_dash_home_stats">

                    @foreach($users as $user)
                    <article class="control radius">
                        <h4 class="icon-users">Clientes</h4>
                        <p><b>Locadores:</b>{{ ($user->lessor == true | $user->lessor == 'on' ? $user->id : '') }}</p>
                        <p><b>Locatários:</b>{{ ($user->lessee == true | $user->lessee == 'on' ? $user->id : '') }}</p>
                        <p><b>Time:</b> 3</p>
                    </article>
                    @endforeach

                    <article class="blog radius">
                        <h4 class="icon-home">Imóveis</h4>
                        <p><b>Disponíveis:</b> 4</p>
                        <p><b>Locados:</b> 0</p>
                        <p><b>Total:</b> 4</p>
                    </article>

                    <article class="users radius">
                        <h4 class="icon-file-text">Contratos</h4>
                        <p><b>Oficializados:</b> 455</p>
                    </article>
                </section>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Últimos Contratos Cadastrados</h2>
            </header>

            <div class="dash_content_app_box">
                <div class="dash_content_app_box_stage">
                    <table id="dataTable" class="nowrap hover stripe" width="100" style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th>Locador</th>
                            <th>Locatário</th>
                            <th>Negócio</th>
                            <th>Início</th>
                            <th>Vigência</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><a href="" class="text-orange">Robson V. Leite</a></td>
                            <td><a href="" class="text-orange">Gustavo Web</a></td>
                            <td>Locação</td>
                            <td><?= date('d/m/Y'); ?></td>
                            <td>12 meses</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Últimos Imóveis Cadastrados</h2>
            </header>

            <div class="dash_content_app_box">
                @foreach($properties as $property)
                <div class="dash_content_app_box_stage">
                    <div class="realty_list">
                        <div class="realty_list_item mt-1 mb-1">
                            <div class="realty_list_item_actions_stats">
                                <img src="{{ $property->cover() }}" alt="">
                                <ul>
                                    <li>Venda: {{ $property->sale_price }}</li>
                                    <li>Aluguel: {{ $property->rent_price }}</li>
                                </ul>
                            </div>

                            <div class="realty_list_item_content">
                                <h4>#{{ $property->id }} {{ $property->category }} - {{ $property->type }}</h4>

                                <div class="realty_list_item_card">
                                    <div class="realty_list_item_card_image">
                                        <span class="icon-realty-location"></span>
                                    </div>
                                    <div class="realty_list_item_card_content">
                                        <span class="realty_list_item_description_title">Bairro:</span>
                                        <span class="realty_list_item_description_content">{{ $property->neighborhood }}</span>
                                    </div>
                                </div>

                                <div class="realty_list_item_card">
                                    <div class="realty_list_item_card_image">
                                        <span class="icon-realty-util-area"></span>
                                    </div>
                                    <div class="realty_list_item_card_content">
                                        <span class="realty_list_item_description_title">Área Útil:</span>
                                        <span class="realty_list_item_description_content">{{ $property->area_util }} m2;</span>
                                    </div>
                                </div>

                                <div class="realty_list_item_card">
                                    <div class="realty_list_item_card_image">
                                        <span class="icon-realty-bed"></span>
                                    </div>
                                    <div class="realty_list_item_card_content">
                                        <span class="realty_list_item_description_title">Domitórios:</span>
                                        <span class="realty_list_item_description_content">{{ $property->bedrooms }} Quartos<br><span>Sendo {{ $property->suites }} suítes</span></span>
                                    </div>
                                </div>

                                <div class="realty_list_item_card">
                                    <div class="realty_list_item_card_image">
                                        <span class="icon-realty-garage"></span>
                                    </div>
                                    <div class="realty_list_item_card_content">
                                        <span class="realty_list_item_description_title">Garagem:</span>
                                        <span class="realty_list_item_description_content">{{ $property->garage + $property->garage_covered }} Vagas<br><span>Sendo {{ $property->garage_covered }} cobertas</span></span>
                                    </div>
                                </div>

                            </div>

                            <div class="realty_list_item_actions">
                                <ul>
                                    <li class="icon-eye">1234 Visualizações</li>
                                </ul>
                                <div>
                                    <a href="" class="btn btn-blue icon-eye">Visualizar Imóvel</a>
                                    <a href="" class="btn btn-green icon-pencil-square-o">Editar Imóvel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection
