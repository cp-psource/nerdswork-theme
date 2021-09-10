addReply = {
    moveForm: function(replyId, parentId, respondId, postId) {
        var t = this,
            div, reply = t.I(replyId),
            respond = t.I(respondId),
            cancel = t.I('psf-cancel-reply-to-link'),
            parent = t.I('psf_reply_to'),
            post = t.I('psf_topic_id');

        if (!reply || !respond || !cancel || !parent)
            return;

        t.respondId = respondId;
        postId = postId || false;

        if (!t.I('psf-temp-form-div')) {
            div = document.createElement('div');
            div.id = 'psf-temp-form-div';
            div.style.display = 'none';
            respond.parentNode.insertBefore(div, respond);
        }

        reply.parentNode.insertBefore(respond);
        if (post && postId)
            post.value = postId;
        parent.value = parentId;
        cancel.style.display = '';

        cancel.onclick = function() {
            var t = addReply,
                temp = t.I('psf-temp-form-div'),
                respond = t.I(t.respondId);

            if (!temp || !respond)
                return;

            t.I('psf_reply_to').value = '0';
            temp.parentNode.insertBefore(respond, temp);
            temp.parentNode.removeChild(temp);
            this.style.display = 'none';
            this.onclick = null;
            return false;
        }

        try { t.I('psf_reply_content').focus(); } catch (e) {}

        return false;
    },

    I: function(e) {
        return document.getElementById(e);
    }
}