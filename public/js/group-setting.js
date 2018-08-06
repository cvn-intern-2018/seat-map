(function ($) {
    $.fn.setCursorPosition = function (pos) {
        this.each(function (index, elem) {
            if (elem.setSelectionRange) {
                elem.setSelectionRange(pos, pos);
            } else if (elem.createTextRange) {
                var range = elem.createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
        });
        return this;
    };
    $(document).ready(function () {
        //======================= Initial data =============================
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#user_group_id").val($(".group-item.active").data("group"));

        //======================= Event handler =============================
        /**
         * Validate field in form create new group and submit
         */
        function handleFormAddGroup() {
            var form = $("form.add-group-item")[0];
            if (!form.checkValidity()) {
                form.reportValidity();
            } else {
                $("form.add-group-item").submit();
            }
        }

        /**
         * Gathering information of user group and upload
         */
        function handleFormUserGroup() {
            var [added, removed] = getGroupUpdate();
            var output = {
                "add": added,
                "remove": removed,
            }
            $("#user-group-data").val(JSON.stringify(output));
            $("form.user-group-setting").submit();

        }

        /**
         * Update group name by AJAX / announce errors
         */
        function updateGroupName(el) {
            var group_item = el.closest(".group-item");
            var group_name = group_item.querySelector(`input[name="group_name"]`).value;
            var group_id = parseInt(group_item.querySelector(`input[name="group_id"]`).value);
            $.ajax({
                url: window.location.origin + "/group-setting/edit",
                method: "POST",
                data: {
                    group_id: group_id,
                    group_name: group_name
                },
                dataType: "json",
                complete: function (response) {
                    var data = JSON.parse(response.responseText);
                    if (response.status === 200
                        && data.result) {
                        $(group_item).removeClass("edit");
                        group_item.querySelector("label").innerHTML = group_name;
                    } else {
                        var timeOutId = 10;
                        var timeOutId = setTimeout(function () {
                            $(`#time-out-${timeOutId}`).fadeOut(function () {
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

        function handleDisableRemoveUnassigned() {
            if ($(`.group-list .group-item[data-group="1"]`).hasClass("active")) {
                $(".arrows .remove-user").addClass("disable");
            } else {
                $(".arrows .remove-user").removeClass("disable");
            }
        }

        //======================= Binding event =============================
        /**
         * Bind event on change group item
         */
        $(".group-list .group-item").click(function () {
            var [added, removed] = getGroupUpdate();
            // console.log(added, removed);
            if (added.length === 0 && removed.length === 0) {
                updateUserSelectPanel(this);
                handleDisableRemoveUnassigned();
            } else {
                $("#changeGroupModal .discard-group-setting").data("group_id", $(this).data("group"));
                $("#changeGroupModal .save-group-setting").data("group_id", $(this).data("group"));
                $("#changeGroupModal").modal("show");
            }
        });

        /**
         * Bind event handler for actions on group-items
         */
        // Edit group name button
        $(".group-button.edit-button").click(function (e) {
            var _parent = $(this).parents(".group-item")
            _parent.addClass("edit")
            var groupNameField = _parent.find(`input[name="group_name"]`)
            groupNameField.focus();
            groupNameField.setCursorPosition(groupNameField.val().length);

        });

        // Save group name button
        $(".group-button.save-button").click(function (e) {
            e.stopPropagation();
            updateGroupName(this);
        });

        // Cancel group name button
        $(".group-button.cancel-button").click(function () {
            var _parent = $(this).parents(".group-item");
            _parent.removeClass("edit");
            _parent.find(`input[name="group_name"]`).val(_parent.find(`label[for="group-name"]`).html());
        });

        // Delete group name button
        $(".group-button.delete-button").click(function(){
            var [added, removed] = getGroupUpdate();
            
            if ( added.length === 0 && removed.length === 0 ) {
                this.closest("form.delete-group-item").submit();
            } else {
                $("#deleteGroupModal").modal("show");  
            }
        });

        // Auto save new name on field loses focus
        $(`.group-display input[name="group_name"]`).focusout(function () {
            updateGroupName(this);
        });

        /**
         * Bind event handler for new group adding form
         */
        $("form.add-group-item .group-button.add-button").click(function () {
            var [added, removed] = getGroupUpdate();

            if (added.length === 0 && removed.length === 0) {
                handleFormAddGroup();
            } else {
                $("#addGroupModal").modal("show");
            }
        });

        $("#addGroupModal .save-group-setting").click(function () {
            handleFormUserGroup();
        });
        $("#addGroupModal .discard-group-setting").click(function () {
            handleFormAddGroup();
            handleDisableRemoveUnassigned();
        })

        /**
         * Bind event handler for group changing popup buttons
         */

        // Bind event for discard button on popup on group changing
        $("#changeGroupModal .discard-group-setting").click(function () {
            var clickTarget = $(`.group-list .group-item[data-group="${$(this).data("group_id")}"]`);
            updateUserSelectPanel(clickTarget);
            $("#changeGroupModal").modal("hide");
            handleDisableRemoveUnassigned();
        });

        // Bind event for save button on popup on group changing
        $("#changeGroupModal .save-group-setting").click(function () {
            handleFormUserGroup();
        });

        /**
         * Bind event handler for group deleting form
         */
        $("form.delete-group-item").click(function () {
            var [added, removed] = getGroupUpdate();
            
            if ( added.length === 0 && removed.length === 0 ) {
                this.submit();
            } else {
                $("#deleteGroupModal").find(".discard-group-setting")
                .data("id", $(this).find(`input[name="group_id"]`).val());
                $("#deleteGroupModal").modal("show");  
            }
        });

        $("#deleteGroupModal .save-group-setting").click(function(){
            handleFormUserGroup();
        });
        $("#deleteGroupModal .discard-group-setting").click(function(){
            document.select
        })

        /**
         * Bind event handler for arrow buttons
         */
        $(".arrows .add-user").click(function () {
            var newUser = $(`#non_member_users`).val();
            newUser.forEach(id => {
                $(`#non_member_users option[value="${id}"]`).attr("hidden", "hidden");
                $(`#member_users option[value="${id}"]`).removeAttr("hidden");
            });
        });
        $(".arrows .remove-user").click(function () {
            var newUser = $(`#member_users`).val();
            newUser.forEach(id => {
                $(`#member_users option[value="${id}"]`).attr("hidden", "hidden");
                $(`#non_member_users option[value="${id}"]`).removeAttr("hidden");
            });
        });

        $(".user-group-setting .save-group-setting").click(handleFormUserGroup)
        $(".user-group-setting .reset-group-setting").click(function () {
            updateUserSelectPanel($(".group-list .group-item.active"));
        })


        //======================= Support function ======================
        /**
         * Get 2 lists of added and removed users.
         */
        function getGroupUpdate() {
            var group_id = $("#user_group_id").val();
            var selected = Array.from(document.querySelectorAll(`#member_users option`)).filter(function (el) {
                return ($(el).data("group") != group_id) &&
                    !el.hasAttribute("hidden");
            }).map(function (el) {
                return $(el).val();
            });
            var removed = Array.from(document.querySelectorAll(`#non_member_users option[data-group="${group_id}"]`))
                .filter(function (el) {
                    return !(el.hasAttribute("hidden"));
                }).map(function (el) {
                    return $(el).val();
                });
            return [selected, removed];
        }

        /**
         * Update user group panel base on group item el
         */
        function updateUserSelectPanel(el) {
            var group_id = $(el).data("group");
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
            $(`#member_users, #non_member_users`).val(0);
            $("#user-group-data").val("");
        }

    });
})($);