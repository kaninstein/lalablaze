<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        .roulette-tile {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sm-box {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            width: 32px;
            border-radius: 4px;
        }

        .sm-box .number {
            font-size: 9px;
            letter-spacing: -.5px;
            color: #bcbfc7;
            padding: 0;
            border: 2px solid #bcbfc7;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -1px;
            border-radius: 50%;
        }

        .sm-box.red .number {
            color: #8c1024;
            border: 2px solid #8c1024;
        }

        .sm-box.white img {
            height: 16px;
        }

        .white {
            background-color: #fff;
        }

        .red {
            background-color: #f12c4c;
        }

        .black {
            background-color: #262f3c;
        }


    </style>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div>
    <table
        class="border-collapse w-full border border-slate-400 dark:border-slate-500 bg-white dark:bg-slate-800 text-sm shadow-sm">
        <thead class="bg-slate-50 dark:bg-slate-700">
        <tr>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Hora
            </th>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Sinal
            </th>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Cálculo
            </th>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Pedras Base
            </th>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Rodada 1
            </th>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Rodada 2
            </th>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Resultado
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($signs as $sign)
            <tr>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">
                    @if(\Carbon\Carbon::parse($sign->sign_time)->format('Y-m-d') == \Carbon\Carbon::now()->format('Y-m-d'))
                        {{ \Carbon\Carbon::parse($sign->sign_time)->format('H:i:s') }}</td>
                    @else
                        {{ \Carbon\Carbon::parse($sign->sign_time)->format('Y-m-d H:i:s') }}</td>
                @endif
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">

                    <div class="flex flex-row justify-center space-x-2">
                        <div class="entry">
                            <div class="roulette-tile">
                                <div class="sm-box white shaddow-lg">
                                    <img alt="0" src="{{ asset('svg/blaze.svg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="entry">
                            <div class="roulette-tile">
                                <div
                                    class="sm-box {{ (($sign->getColor()->color == 0) ? 'white' : (($sign->getColor()->color == 1) ? 'red' : 'black')) }}">
                                    @if($sign->getColor()->color == 0)
                                        <img alt="0" src="{{ asset('svg/blaze.svg') }}">
                                    @else

                                        <div class="number">

                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">
                    @if($sign->count_mode == 1)
                        + {{ $sign->getColor()->number }}
                    @elseif($sign->count_mode == 2)
                    + {{ ($sign->getBlank() + $sign->getColor()->number) }}
                    @elseif($sign->count_mode == 3)
                    + {{ ($sign->getBlank() * $sign->getColor()->number) }}
                    @endif
                </td>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">
                    <div class="flex flex-row justify-center space-x-8">
                        <div class="entry">
                            <a
                                href="{{ url("/blank/{$sign->base_blank_id}") }}"
                                target="_blank">
                                <div class="roulette-tile">
                                    <div
                                        class="sm-box {{ (($sign->getColor()->color == 0) ? 'white' : (($sign->getColor()->color == 1) ? 'red' : 'black')) }}">
                                        @if($sign->getColor()->color == 0)
                                            <img alt="0" src="{{ asset('svg/blaze.svg') }}">
                                        @else

                                            <div class="number">
                                                {{ $sign->getColor()->number }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            {{ \Carbon\Carbon::parse($sign->getBlank()->roll_time)->format('H:i:s') }}
                        </div>
                        <div class="entry">
                            <a
                                href="{{ url("/roll/{$sign->base_color_id}") }}"
                                target="_blank">
                                <div class="roulette-tile">
                                    <div
                                        class="sm-box {{ (($sign->getColor()->color == 0) ? 'white' : (($sign->getColor()->color == 1) ? 'red' : 'black')) }}">
                                        @if($sign->getColor()->color == 0)
                                            <img alt="0" src="{{ asset('svg/blaze.svg') }}">
                                        @else

                                            <div class="number">
                                                {{ $sign->getColor()->number }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            {{ \Carbon\Carbon::parse($sign->getColor()->roll_time)->format('H:i:s') }}
                        </div>
                    </div>
                </td>
                @foreach($sign->getRolls() as $roll)
                    <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">
                        <div class="entry">

                            <div class="roulette-tile">
                                <div
                                    class="sm-box {{ (($roll->color == 0) ? 'white' : (($roll->color == 1) ? 'red' : 'black')) }}">
                                    @if($roll->color == 0)
                                        <img alt="0" src="{{ asset('svg/blaze.svg') }}">
                                    @else

                                        <div class="number">
                                            {{ $roll->number }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{ \Carbon\Carbon::parse($roll->roll_time)->format('H:i:s') }}
                    </td>
                @endforeach
                @if($sign->getRolls()->count() == 0)
                    <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"></td>
                    <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"></td>
                @elseif($sign->getRolls()->count() == 1)
                    <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"></td>
                @endif
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">
                    @if($sign->getResult())
                        ✅
                    @else
                        ❌
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $signs->links() }}
</div>
</body>
</html>
