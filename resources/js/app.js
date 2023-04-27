import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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

    document.querySelector('.follow_button').addEventListener('click', clickFollow);
    document.querySelector('.unfollow_button').addEventListener('click', clickUnfollow);
}

function attachReplyButtons() {
    function clickReply(event) {
        let postId = event.target.dataset.postId;
        let repliesLoaded = event.target.dataset.repliesLoaded == 1;
        let repliesShowing = event.target.dataset.repliesShowing == 1;

        if (!repliesLoaded) {
            fetch(`/replies?post_id=${ postId }`)
                .then(res => res.text())
                .then(function(text) {
                    let postRoot = event.target.parentElement.parentElement.parentElement.parentElement;
                    postRoot.insertAdjacentHTML('beforeend', text);

                    let post = event.target.parentElement.parentElement.parentElement;
                    post.classList.add('border-b');

                    event.target.dataset.repliesLoaded = 1;
                    event.target.dataset.repliesShowing = 1;
                });
            return;
        }
        let repliesContainer = event.target.parentElement.parentElement.parentElement.parentElement.children[1];
        if (!repliesShowing) {
            repliesContainer.classList.remove('hidden');
            event.target.dataset.repliesShowing = 1;
            return;
        }
        repliesContainer.classList.add('hidden');
        event.target.dataset.repliesShowing = 0;
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
    let postIds = [];
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
