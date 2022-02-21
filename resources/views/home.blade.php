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
        <!-- JQuery Tingle Modal -->
        <link rel="stylesheet" href="{{asset('vendor/tingle-master/dist/tingle.min.css')}}">
        <!-- JQuery Font Awesome  -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Third Pary JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <div class="flex-col">
          <div class="flex mb-2">
            <label>Show 
              <select id="show_entries" name="show_entries">
                <option value="2" @if($limit == 2) selected @endif>2</option>
                <option value="4" @if($limit == 4) selected @endif>4</option>
                <option value="5" @if($limit == 5) selected @endif>5</option>
                <option value="6" @if($limit == 6) selected @endif>6</option>
              </select> entries
            </label>
          </div>
          <div class="overflow-x-auto shadow-md sm:rounded-lg">
              <div class="inline-block min-w-full align-middle">
                  <div class="overflow-hidden">
                      {!! csrf_field() !!}
                      <table id="moviesTbl" class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 mb-5">
                          <thead class="bg-gray-100 dark:bg-gray-700">
                              <tr>
                                  <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                      Movie Name
                                  </th>
                                  <th scope="col" class="flex py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                      <span class="mr-2">Vote Average</span>
                                      <div class="flex flex-col">
                                        @if(empty($txt_sort) || $txt_sort != "popular")
                                        <a href="{{route('homepage',['sort' => 'popular','page' => $page,'limit' => $limit])}}" >
                                          <i class="fas fa-sort-up"></i>
                                        </a>
                                        @else
                                        <a href="{{route('homepage',['sort' => 'unpopular','page' => $page,'limit' => $limit])}}" >
                                          <i class="fas fa-sort-down"></i>
                                        </a>
                                        @endif
                                      </div>
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
                                        <a href="#" class="getDetails text-blue-600 dark:text-blue-500 hover:underline" data-id="{{$item['_id']}}">Details</a>
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
          <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
              <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
              <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing
                  <span class="font-medium">{{$start}}</span>
                  to
                  <span class="font-medium">{{$end}}</span>
                  of
                  <span class="font-medium">{{$total}}</span>
                  results
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <a @if($page == 1) href="#" @else href="{{route('homepage',['sort' => $txt_sort,'page' => $page-1,'limit' => $limit])}}" @endif class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Previous</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                  </a>
                  @for($x = 1; $x <= $total_pages; $x++)
                  <a href="{{route('homepage',['sort' => $txt_sort,'page' => $x,'limit' => $limit])}}" aria-current="page" class="z-10 @if($page == $x) bg-indigo-50  border-indigo-500 text-indigo-600 @else border-gray-300 text-gray-500 @endif relative inline-flex items-center px-4 py-2 border text-sm font-medium"> {{$x}} </a>
                  @endfor
                    <a @if($total_pages == $page) href="#" @else href="{{route('homepage',['sort' => $txt_sort,'page' => $page+1,'limit' => $limit])}}" @endif class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Next</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                  </a>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>
