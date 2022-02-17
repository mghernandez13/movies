  $(document).ready(function() {

            $('#loading-image').hide();

            var modal = new tingle.modal({
                footer: true,
                stickyFooter: false,
                closeMethods: ['overlay', 'button', 'escape'],
                closeLabel: "Close",
                cssClass: ['custom-class-1', 'custom-class-2']
            });

            modal.addFooterBtn('Close', 'tingle-btn shade-bg-theme-color', function() {
              modal.close();
            });

            $('.getDetails').click(function() {
              var title     = $(this).data('title');
              var _token = $('input[name=_token]').val();
              $(this).attr('disabled',true);
              $.ajax({
                  url: "/getMoviesById",
                  method: "post",
                  cache: true,
                  dataType: 'json',
                  data: {
                    title,
                    _token
                  },
                  beforeSend: function() {
                    $('#loading-image').show();
                  },
                  success: function (details) {
                    if(details.message == "success") {
                      console.log(details);
                      modal.setContent(`
                            <div class="flex-column">
                              <div class="flex mb-4">
                                <h1 class="text-bold text-2xl">Movie Details</h1>
                              </div>
                              <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="flex-column">
                                  <div class="flex">
                                    <label class="font-bold text-lg mr-2">Title:</label>
                                    <span class="font-semibold text-lg">${details.data.document['Title']}</span>
                                  </div>
                                  <div class="flex">
                                    <label class="font-bold text-lg mr-2">Voter Average:</label>
                                    <span class="font-semibold text-lg">${details.data.document['Voter Average']}</span>
                                  </div>
                                  <div class="flex">
                                    <label class="font-bold text-lg mr-2">Release Date:</label>
                                    <span class="font-semibold text-lg">${details.data.document['Release Date']}</span>
                                  </div>
                                </div>
                                <div class="flex-column">
                                  <div class="flex">
                                    <img class="w-full object-contain max-h-80" src="${details.data.document['Poster']}" />
                                  </div>
                                </div>
                              </div>
                              <div class="flex-col">
                                <label class="font-bold text-lg mr-2">Overview:</label>
                                <span class="font-semibold text-lg">${details.data.document['Overview']}</span>
                              </div>
                            </div>
                          `);
                      modal.open();
                    } else {
                        alert(details.message);
                    }
                    $('#loading-image').hide();
                  }, error: function() {
                    alert('Error! Please try again later');
                    $('#loading-image').hide();
                  }
              });
            });

            $('#moviesTbl').DataTable({
              "pageLength": 5
            })
            
          })