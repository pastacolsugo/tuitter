import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const refreshRepliesEvent = new Event('refreshReplies');

function attachLikeButtons() {
    function clickLike(event) {
        const postId = event.target.dataset.postId;
        fetch(`/like?post_id=${ parseInt(postId) }`, { method: 'POST' })
            .then(res => res.text())
            .then(function (res_text) {
                if (res_text == 'liked') {
                    event.target.classList.add('text-red-500');
                    return;
                }
                if (res_text == 'unliked') {
                    event.target.classList.remove('text-red-500');
                    return;
                }
            });
    }

    let buttons = document.querySelectorAll('.like_button');
    buttons.forEach((b) => b.addEventListener('click', clickLike));
}

function attachFollowButtons() {
    function clickFollow(event) {
        const profileId = event.target.dataset.profileId;
        fetch(`/follow?followee_id=${ profileId }`, {
            method: 'POST',
        }).then(res => res.status)
        .then(function (s) {
            if (s != 200) {
                console.log(`Error: follow -> HTTP ${s}`);
                return;
            }
            event.target.classList.add('hidden');
            document.querySelector('.unfollow_button').classList.remove('hidden');
        });
    }

    function clickUnfollow(event) {
        const profileId = event.target.dataset.profileId;
        fetch(`/unfollow?followee_id=${ profileId }`, {
            method: 'POST',
        }).then(res => res.status)
        .then(function (s) {
            if (s != 200) {
                console.log(`Error: follow -> HTTP ${s}`);
                return;
            }
            event.target.classList.add('hidden');
            document.querySelector('.follow_button').classList.remove('hidden');
        });
    }

    let follow_button = document.querySelector('.follow_button');
    if (follow_button != null) {
        follow_button.addEventListener('click', clickFollow);
    }

    let unfollow_button = document.querySelector('.unfollow_button');
    if (unfollow_button != null) {
        unfollow_button.addEventListener('click', clickUnfollow);
    }
}

function attachReplyButtons() {
    function loadReplies(postRoot, postId) {
        if (postRoot === null || postId === null) {
            return;
        }
        fetch(`/replies?post_id=${postId}`)
            .then(res => res.text())
            .then(function(text) {
                if (postRoot.children.length >= 2 && postRoot.children[1].classList.contains('replies-container')) {
                    postRoot.children[1].remove();
                }
                postRoot.insertAdjacentHTML('beforeend', text);

                let post = postRoot.children[0];
                post.classList.add('border-b');

                postRoot.dataset.repliesLoaded = 1;
                postRoot.dataset.repliesShowing = 1;

                let reply_button = postRoot
                    .children[1]
                    .children[postRoot.children[1].children.length - 1]
                    .children[0]
                    .children[1]
                    .children[2];
                reply_button.addEventListener('click', sendReply);
            })
    }

    function sendReply(event) {
        let postRoot = event.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
        let postId = event.target.dataset.postId;

        let textArea = event.target.parentElement.parentElement.children[1];
        let content = textArea.value;
        if (content === '') {
            return;
        }
        // console.log(`submitting ${content} for ${postId}`);
        let body = JSON.stringify({ postID : postId, reply : content });
        fetch('/reply', { method: 'POST', body: body})
            .then(res => res.status)
            .then(function(status) {
                textArea.value = '';
                loadReplies(postRoot, postId);
            })
    };

    function clickReply(event) {
        let postId = event.target.dataset.postId;
        let postRoot = event.target.parentElement.parentElement.parentElement.parentElement;
        let repliesLoaded = postRoot.dataset.repliesLoaded == 1;
        let repliesShowing = postRoot.dataset.repliesShowing == 1;

        if (!repliesLoaded) {
            loadReplies(postRoot, postId);
            return;
        }
        let repliesContainer = event.target.parentElement.parentElement.parentElement.parentElement.children[1];
        let post = event.target.parentElement.parentElement.parentElement;
        if (!repliesShowing) {
            repliesContainer.classList.remove('hidden');
            post.classList.add('border-b');
            postRoot.dataset.repliesShowing = 1;
            return;
        }
        repliesContainer.classList.add('hidden');
        post.classList.remove('border-b');
        postRoot.dataset.repliesShowing = 0;
        return;
    }
    document.querySelectorAll('.reply_button').forEach((b) => b.addEventListener('click', clickReply));
}

function attachButtons() {
    attachLikeButtons();
    attachFollowButtons();
    attachReplyButtons();
    attachShareButtons();
}

function setPostLikes() {
    document.querySelectorAll('.like_button')
        .forEach(function(e) {
            fetch(`/like?post_id=${ e.dataset.postId }`)
            .then(res => res.text())
            .then(function(text) {
                if (text == 'liked') {
                    e.classList.add('text-red-500');
                }
            });
        });
}

function setProfileFollow() {
    const regex = new RegExp('/profile/[0-9]+')
    if (!regex.test(window.location.pathname)) {
        return;
    }
    const profileId = window.location.pathname.split('/')[2];
    fetch(`/follow?followee_id=${ profileId }`)
        .then(res => res.text())
        .then(function(text) {
            if (text == 'following') {
                document.querySelector('.follow_button').classList.add('hidden');
                document.querySelector('.unfollow_button').classList.remove('hidden');
            }
        });
}

function windowOnLoad() {
    setPostLikes();
    setProfileFollow();
    attachButtons();
}

window.onload = windowOnLoad;
