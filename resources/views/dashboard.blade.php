@extends("index")

@section("module", "Dashboard")

@section("content")
    {{--NODES--}}
    <h6 class="text-5xl pt-14 text-center">Nodes</h6>
    <div class="flex flex-wrap justify-center gap-6 mt-8">
        @foreach($nodeResponse["nodes"] as $node)
            @php
                $state = $node['state'] ?? 'UNKNOWN';
                $headerColor = match($state) {
                    'READY' => 'bg-green-600',
                    'UNAVAILABLE' => 'bg-red-600',
                    default => 'bg-yellow-500',
                };
            @endphp

            <div class="bg-base-200 shadow-lg rounded-xl border border-none w-full sm:w-80">
                <div class="{{ $headerColor }} p-4 rounded-t-xl">
                    <h3 class="text-primary-content text-xl font-semibold">{{ $node['node']['uniqueId'] }}</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <h4 class="font-medium">Addresses / Ports</h4>
                        <ul class="mt-2 space-y-1">
                            @foreach($node['node']['listeners'] as $listener)
                                <li class="flex items-center gap-2">
                                    <span class="bg-accent-content text-blue-800 font-semibold px-2 py-0.5 rounded">
                                        {{ $listener['host'] }}:{{ $listener['port'] }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if(!empty($node['node']['properties']))
                        <div>
                            <h4 class="font-medium text-gray-700">Properties</h4>
                            <pre class="bg-gray-100 p-2 rounded text-sm text-gray-700">{{ print_r($node['node']['properties'], true) }}</pre>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    {{--TASKS--}}
    <h6 class="text-5xl pt-14 text-center">Current Tasks</h6>
    <div class="flex flex-wrap justify-center gap-6 mt-8">
        @foreach($tasksResponse['tasks'] as $task)
            <div class="bg-base-200 shadow-lg rounded-xl border border-none w-full sm:w-80">
                <div class="bg-info p-4 rounded-t-xl">
                    <h3 class="text-primary-content text-xl font-semibold">{{ $task['name'] }}</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <h4 class="font-medium">Start Port</h4>
                        <ul class="mt-2 space-y-1">
                            <li class="flex items-center gap-2">
                                <span class="bg-accent-content text-blue-800 font-semibold px-2 py-0.5 rounded">
                                    {{ $task['startPort'] }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{--SERVICES--}}
    <h6 class="text-5xl pt-14 text-center">Current Services</h6>
    <div class="flex flex-wrap justify-center gap-6 mt-8">
        @foreach($serviceResponse['services'] as $service)
            <div class="bg-base-200 shadow-lg rounded-xl border border-none w-full sm:w-80">
                <div class="bg-info p-4 rounded-t-xl">
                    <h3 class="text-primary-content text-xl font-semibold">
                        {{ $service['configuration']['serviceId']['taskName'] }}{{ $service['configuration']['serviceId']['nameSplitter'] }}{{ $service['configuration']['serviceId']['taskServiceId'] }}
                    </h3>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <h4 class="font-medium">Start Port</h4>
                        <ul class="mt-2 space-y-1">
                            <li class="flex items-center gap-2">
                                <span class="bg-accent-content text-blue-800 font-semibold px-2 py-0.5 rounded">
                                    {{ $service['address']['host'] }}:{{ $service['address']['port'] }}
                                </span>
                            </li>
                        </ul>
                        <h4 class="pt-2 font-medium">Server Type</h4>
                        <ul class="mt-2 space-y-1">
                            <li class="flex items-center gap-2">
                                <span class="bg-accent-content text-blue-800 font-semibold px-2 py-0.5 rounded">
                                    {{ $service['configuration']['serviceId']['environmentName'] }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
