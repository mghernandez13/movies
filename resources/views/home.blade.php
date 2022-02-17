<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Main CSS -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <!-- Tailwind CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
        <!-- JQuery Data Tables -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <!-- JQuery Data Tables -->
        <link rel="stylesheet" href="{{asset('vendor/tingle-master/dist/tingle.min.css')}}">

        <!-- Third Pary JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="{{URL::asset('vendor/tingle-master/dist/tingle.min.js')}}"></script>

        <!-- Main JS -->
        <script src="{{URL::asset('js/app.js')}}"></script>
    </head>
    <body  id="body-container" class="antialiased">
      <div id="loading-image">
            <img src="{{ URL::asset('img/Loading.gif') }}" alt="" style="width: 200px;">
        </div>
      <div class="flex w-full text-center my-10 justify-center">
        <h1 class="text-5xl font-bold">Popular Movies</h1>
      </div>
      <div class="max-w-2xl mx-auto">
        <div class="flex flex-col">
          <div class="overflow-x-auto shadow-md sm:rounded-lg">
              <div class="inline-block min-w-full align-middle">
                  <div class="overflow-hidden">
                      {!! csrf_field() !!}
                      <table id="moviesTbl" class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 my-5 pt-5">
                          <thead class="bg-gray-100 dark:bg-gray-700">
                              <tr>
                                  <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                      Movie Name
                                  </th>
                                  <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                      Vote Average
                                  </th>
                                  <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-right text-gray-700 uppercase dark:text-gray-400">
                                      Action
                                  </th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                              @forelse($response['documents'] as $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$item['Title']}}</td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">{{$item['Voter Average']}}</td>
                                    <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                        <a href="#" class="getDetails text-blue-600 dark:text-blue-500 hover:underline" data-title="{{$item['Title']}}">Details</a>
                                    </td>
                                </tr>
                              @empty
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                  <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap" colspan="4">
                                    <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">No Data Available</a>
                                  </td>
                                </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </body>
</html>
