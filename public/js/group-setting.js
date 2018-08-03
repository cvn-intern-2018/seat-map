(function($){
    $(document).ready(function(){
        $("#user_group_id").val($(".group-item.active").data("group"));
        $(".group-list .group-item").click(function(){
            var [added, removed] = getGroupUpdate(this);
            console.log(added, removed);
            if ( added.length === 0 && removed.length === 0 ) {
                updateGroupPanel(this);
            } else {
                
            }
        });
        $(".group-button.edit-button").click(function (e) {
            e.stopPropagation();
            $(this).parents(".group-item").addClass("edit")
        })
        $(".group-button.save-button").click(function (e) {
            e.stopPropagation();
            updateEditGroup(this);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //======================= Support function ======================
        function getGroupUpdate(el){
            var group_id = $("#user_group_id").val();
            var selected = $(`#member_users option`).filter(function(){
                return ($(this).data("group") != group_id) &&
                    !this.hasAttribute("hidden");
                }).map(function () {
                    return $(this).val();
                });
            var removed = $(`#non_member_users option[data-group="${group_id}"]`)
                .filter(function(){
                    return !this.hasAttribute("hidden");
                }).map(function () {
                    return $(this).val();
                });
            return [selected, removed];
        }
        function updateGroupPanel(el) {
            var group_id = $(el).data("group");
            console.log(group_id);
            $("#user_group_id").val(group_id);
            $(".group-list .group-item").removeClass("active");
            $(el).addClass("active");

            // Update control panel fields
            $(`#member_users option`).attr("hidden", "hidden");
            $(`#member_users option[data-group="${group_id}"],
                #non_member_users option`).removeAttr("hidden");
            $(`#non_member_users option[data-group="${group_id}"]`)
                .attr("hidden", "hidden");
            $(".group-title").html($(el).text());
        }
        function updateEditGroup(el) {
            var group_item = el.closest(".group-item");
            var group_name = group_item.querySelector(`input[name="group_name"]`).value;
            var group_id = parseInt(group_item.querySelector(`input[name="group_id"]`).value);
            $.ajax({
                url: window.location.origin + "/group-edit",
                method: "POST",
                data: {
                    group_id: group_id,
                    group_name: group_name
                },
                dataType: "json",
                complete: function (response){
                    var data = JSON.parse(response.responseText);
                    console.log(data);
                    if (response.status === 200 
                        && data.result) {
                            $(group_item).removeClass("edit");
                            group_item.querySelector("label").innerHTML = group_name;
                    } else {
                        var timeOutId =10;
                        var timeOutId = setTimeout(function(){
                            $(`#time-out-${timeOutId}`).fadeOut(function(){
                                $(this).remove();
                            });
                        }, 5000);
                        $(group_item).children(".group-display").eq(0).append(`
                            <div id="time-out-${timeOutId}" class="alert alert-danger">
                                ${data.message}
                            </div>`
                        );
                        $(group_item).find(`input[name="group_name"]`).val(
                            $(group_item).find(`label[for="group-name"]`).eq(0).html()
                        );
                    }
                }
            })
        }
    });
})($);