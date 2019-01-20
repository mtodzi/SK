<?php
            foreach ($models as $model) {
                //echo $model->body_post." - ".date('d-m-Y H:i:s',$model->created_at);
                $bloc = "<li>"
                    ."<a href=".">"
                        ."<span class='image'>"
                            ."<img src='".$model->userFromWhom->getUrlMiniature()."' alt='img'>"
                        ."</span>"
                        ."<span>"
                            ."<span>".$model->userFromWhom->employeename."</span>"
                            ."<span class='time' style='right:85px;' >".date('d-m-Y H:i:s',$model->created_at)."</span>"
                        ."</span>"
                        ."<span class='message_post'>"
                            .$model->body_post
                        ."</span>"
                        ."<input type='hidden' class = 'content_input' value = ".$count_qvery.">"
                    ."</a>"
                ."</li>";
                echo $bloc;
                
            }
?>            
