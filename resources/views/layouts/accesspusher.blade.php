<script type="text/javascript">	
    var notificationsCount = $('#count-noti').data('count');
    var notifications = $('.notification-list').find('.notification-list');
    var id_user = $('#id_user').val();
    Pusher.logToConsole = true;
    var pusher = new Pusher('3ffdd80b318a32b5d843', {
        cluster: 'ap1',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
            'X-CSRF-Token': $('#csrf').val(),
            }
        }
    });
    var channel = pusher.subscribe('private-my-channel.' + id_user);
    channel.bind('App\\Events\\ActionRealtimeEvent', function(data) {
        var existingNotifications = notifications.html();
        var notificationsCountAfter = $('#count-noti').text(parseInt(notificationsCount) + 1);
        notificationsCount += 1;
        $('.span-count-noti').attr('data-count', notificationsCount);
        toastr.success(Lang.get(data.data['user_name']) + " " + Lang.get(data.data['action']) + " " + Lang.get(data.data['for_you']));
        let url = `{{ route('read.noti') }}`;
        let fullURL = url +  '/' + data.data['id'];
        var newNotication = `<a class="read-noti" href="${ fullURL }"><div class="notification-unread"><span>${ Lang.get(data.data['user_name']) }</span>&nbsp;<span>${ Lang.get(data.data['action']) }</span>&nbsp;<span>${ Lang.get(data.data['for_you']) }</span></div></a><hr>`;
        $('.notification-list0').prepend(newNotication);
    });
</script>
