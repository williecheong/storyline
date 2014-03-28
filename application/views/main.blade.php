<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="shortcut icon" href="{{ $settings['story_favicon'] }}" type="image/x-icon">
        <link rel="icon" href="{{ $settings['story_favicon'] }}" type="image/x-icon">
        <title>{{ $settings['story_title'] }}</title>
        <meta name="description" content="{{ $settings['story_description'] }}">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/basic/jquery.qtip.min.css">
        <link rel="stylesheet" href="/assets/vendor/spectrum/spectrum.css">
        <link rel="stylesheet" href="/assets/css/main.css">
        <script src="/assets/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script> 
    </head>    
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
            <?php
                $chapter_num = 1; 
                $prev_chap_ordering = 0;
                $new_chap_ordering = 0;
                
                //Must be reset at every chapter
                $prev_para_ordering = 0;
                $new_para_ordering = 0;
            ?>
            <!-- Big story title on top of page -->
            <div class="row" style="margin-bottom:10px;">
                <div class="col-lg-offset-1"></div>
                <div class="story-title text-center col-lg-10 col-lg-offset-1">
                    <h1><span class="request-synopsis-modal">{{ $settings['story_title'] }}</span></h1>
                </div>
                <div class="col-lg-1 text-center">
                    <button class="btn enable-editing">Edit</button>
                </div>
            </div>
            @foreach($chapters as $chapter)
                <?php $prev_para_ordering = 0; ?>
                
                {{-- Start of option to add an in between chapter --}}
                <div class="new-chap chapter-content well">
                    <p class="new-para">
                        <?php $new_chap_ordering = ($prev_chap_ordering + $chapter->ordering) / 2 ; ?>
                        <a class="new-chap-show" data-author="{{$user_email}}" data-chapter-ordering="{{$new_chap_ordering}}">
                            <em><small>Psst, come add a new chapter here.</small></em>
                        </a>
                    </p>
                </div>
                
                <div class="chapter-content well"> 
                    <p class="lead">
                        Chapter {{ $chapter_num }} 
                        @if( !empty($chapter['title']) )<small>{{$chapter['title']}}</small>@endif
                    </p>
                    
                    {{-- Start of paragraphing for this chapter --}}
                    @foreach($chapter['paragraphs'] as $paragraph)
                        {{-- Option to add new paragraph before the new one --}}
                        <p class="new-para">
                            <?php $new_para_ordering = ($prev_para_ordering + $paragraph['ordering']) / 2; ?>
                            <a class="new-para-show" data-author="{{$user_id}}" data-chapter="{{$chapter['chap_id']}}" data-para-ordering="{{ $new_para_ordering }}">
                                <em><small>Add a new paragraph here.</small></em>
                            </a>
                        </p>
                        {{-- Displays the next-in-line and edit paragraph option --}}
                        <p class="existing-para">
                            {{ EasyParagraph::htmlreadify( EasyParagraph::untrack( $paragraph['content'] ) ) }} 
                            <a class="edit-para-show edit-para" data-author="{{ $user_id }}" data-paragraph="{{ $paragraph['para_id'] }}" data-para-cont="{{esc_doublequote(textreadify(untrack( $paragraph['content'])))}}"><small>edit</small></a>
                        </p>
                        <?php $prev_para_ordering = $paragraph['ordering']; ?>
                    @endforeach
                    
                    {{-- Add new paragraph at the end of chapter --}}
                    <p class="new-para">
                        <?php $new_para_ordering = $prev_para_ordering + 10000; ?>
                        <a class="new-para-show" data-author="{{ $user_email }}" data-chapter="{{$chapter['chap_id']}}" data-para-ordering="{{ $new_para_ordering }}">
                            <em><small>Add a new paragraph here.</small></em>
                        </a>
                    </p>
                </div>
                <?php $prev_chap_ordering = $chapter['ordering']; $chapter_num++; ?>
            @endforeach 
            
            {{-- Add new chapter at end of story --}}    
            <div class="new-chap chapter-content well">
                <p class="lead">Chapter {{ $chapter_num }}</p>
                <p class="new-para">
                    <?php $new_chap_ordering = $prev_chap_ordering + 10000; ?>
                    <a class="new-chap-show" data-author="{{$user_id}}" data-story="{{$story['stor_id']}}" data-chapter-ordering="{{$new_chap_ordering}}">
                        <em><small>Psst, come add a new chapter here.</small></em>
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <footer>
                <hr>
                <p>&copy; Legend of Tradester - Powered by StoryLine {{ date("Y") }}</p>
            </footer><!-- /.footer -->
        </div><!-- /container -->

        <!-- Modal for displaying synopsis -->
        <div class="modal fade" id="display-synopsis" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">{{ $settings['story_title'] }}</h4>
                    </div>
                    <div class="modal-body">            
                        <p>{{ $settings['story_synopsis'] }}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>
                </div>
            </div>
        </div><!-- /displaying synopsis -->

        <!-- Modal for adding new chapters  -->
        <div class="modal fade" id="addnewchap" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Contribute - New chapter</h4>
                    </div>
                    <div class="modal-body text-center">            
                        <p><textarea class="form-control addnewchap-cont_content" rows="14" style="resize:none;" placeholder="Your new chapter for this story; write away..."></textarea></p>
                        <p><textarea class="form-control addnewchap-cont_description" rows="3" maxlength="" style="resize:none;" placeholder="Briefly describe this contribution. This will only serve as a summary to help directors moderate."></textarea></p>
                        
                        <input class="addnewchap-stor_id" value="" type="hidden">
                        <input class="addnewchap-chap_ordering" value="" type="hidden">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="post-new-chap btn btn-small btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div><!-- /adding new chapters  -->

        <!-- Modal for adding new paragraphs -->
        <div class="modal fade" id="addnewpara" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Contribute - New paragraph</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p><textarea class="form-control addnewpara-cont_content" rows="14" style="resize:none;" placeholder="Your new paragraph for this story chapter; write away..."></textarea></p>
                        <p><textarea class="form-control addnewpara-cont_description" rows="3" maxlength="" style="resize:none;" placeholder="Briefly describe this contribution. This will only serve as a summary to help directors moderate."></textarea></p>
                        
                        <input class="addnewpara-chap_id" value="" type="hidden">
                        <input class="addnewpara-para_ordering" value="" type="hidden">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="post-new-para btn btn-small btn-success">Submit</button>
                    </div>
                </div>
            </div>  
        </div><!-- /adding new paragraphs -->
        
        <!-- Modal for editing existing paragraphs  -->
        <div class="modal fade" id="editpara" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Contribute - Edit paragraph</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p><textarea class="form-control editpara-cont_content" rows="14" style="resize:none;" placeholder="Make your edits to this paragraph here."></textarea></p>
                        <p><textarea class="form-control editpara-cont_description" rows="3" maxlength="" style="resize:none;" placeholder="Briefly describe this contribution. This will only serve as a summary to help directors moderate."></textarea></p>
                        
                        <input class="editpara-old_content" value="" type="hidden">
                        <input class="editpara-para_id" value="" type="hidden">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="post-edit-para btn btn-small btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div><!-- /editing paragraphs  -->  

        <!-- Modal for bug report -->
        <div class="modal fade" id="bugreport" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Bug Report</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p><input class="form-control buggy-email" value="{{ $user_email }}" type="text" placeholder="Your email address"></p>
                        <p><textarea class="form-control buggy-message" rows="8" maxlength="" style="resize:none;" placeholder="ʕʘ‿ʘʔ What happened? Or you can also request a new feature here."></textarea></p>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="post-buggy btn btn-small btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div><!-- /bugreport -->
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/basic/jquery.qtip.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="/assets/vendor/spectrum/spectrum.js"></script>
        <script src="//login.persona.org/include.js"></script>
        <script src="/assets/js/main.js"></script>
        <script>
            /***********************
                Setup for Persona
                Referenced from: 
                    https://github.com/EllisLab/CodeIgniter/wiki/Persona-Login
            ***********************/ 
            navigator.id.watch({
                loggedInUser: {{ $user_email ? '"'.user_email.'"' : 'null' }},
                onlogin: function (assertion) {
                    $.ajax({
                        type: 'POST',
                        url: '/api/misc/login',
                        data: { assertion: assertion },
                        success: function(response, status, xhr) {
                            if ( response == 'OK' ){
                                window.location.reload();
                            } else {
                                console.log(response);
                                alert(response);
                            }
                        },
                        error: function(response, status, xhr) {
                            console.log(response);
                            alert('Login failed');
                        }
                    });
                },

                onlogout: function () {
                    $.ajax({
                        type: 'POST',
                        url: '/api/misc/logout',
                        success: function(response, status, xhr) {
                            window.location.reload();
                        },
                        error: function(response, status, xhr) {
                            console.log(response);
                            alert('Logout failed');
                        }
                    });
                }
            });
        </script>
    </body>
</html>




