<!-- @push('footerscripts') -->
<style>
    .stw-modal {
        transition: all .25s;
        opacity:0;
        background-color:rgb(0 0 0 / 67%);
    }
    .stw-modal.popup {
        transition: all .25s;
        opacity:1;
        z-index:1000;
    }
    .stw-modal .overflow-scroll {
        -webkit-overflow-scrolling: touch;
    }
    .body-overflow-none {
        overflow: hidden;
        position: relative;
    }
</style>
<script>
    jQuery().ready(function($){
        $(".stw-modal").each(function(){
            var modalSelf = $(this);
            var container = modalSelf.find('.modal-container');
            var modalId = $(this).attr('id');
            var modalToggle = "." + modalId;
            var body = document.getElementsByTagName("BODY")[0];
            var modalOpenTimer = 0;
            function myTimer() {
                modalOpenTimer++;
            }
            var modal_timer;
            $(modalToggle).click(function() {
                // TO DO: Set Timer Tracker
                modal_timer = setInterval(myTimer, 1000);

                if ($(container).hasClass('mobile-content')){
                    modalSelf.css('display','block');
                } else {
                    modalSelf.css('display','flex');
                }
                $(body).addClass('body-overflow-none');
                $('html').addClass('body-overflow-none');

                setTimeout(function(){
                    modalSelf.css('opacity','100');
                    $(this).find('.modal-close').fadeIn();
                    // logSTWEvent('modal_opened',{modal_id: modalId});
                },250); 
            });

            // Escape Button
            $(document).on('keyup',function(e){
                if($(modalSelf).is(':visible')){
                    if (e.key === "Escape") { 
                        modalSelf.modalHide();
                        var modal_close_type = "escape";
                    } 
                    else if (e.keyCode == 27) {
                        modalSelf.modalHide();
                        var modal_close_type = "escape";
                    }
                }
            })
            //close button
            $(this).find('.modal-close-div').on('click',function(){
                var modal_close_type = "close-button";
                modalSelf.modalHide();
            })
            //Click Outside
            $(this).on('mousedown',function(e){
                if ($(e.target).hasClass('click-outside-to-close')){
                    var modal_close_type = "click-outside";
                    modalSelf.modalHide();
                }
            })
            
            modalSelf.modalHide = function(){
                modalSelf.css('opacity','0');
                $(body).removeClass('body-overflow-none');
                $('html').removeClass('body-overflow-none');
                setTimeout(function(){
                    modalSelf.hide();
                },250);   
                // logSTWEvent('modal_closed',{modal_id: modalId, modal_open_time: modalOpenTimer});
                clearInterval(modal_timer);
                modalOpenTimer = 0;
            }
        })
    })
    </script>

<!-- @endpush -->

