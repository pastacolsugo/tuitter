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
            });
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

function attachMoreButtons() {
    function moreButton(event) {
        let more_container = event.target.parentElement.nextElementSibling;
        console.log(more_container);

        if (more_container.classList.contains('hidden')) {
            more_container.classList.remove('hidden');
        } else {
            more_container.classList.add('hidden');
        }
    }

    let buttons = document.querySelectorAll('.more_button');
    buttons.forEach((b) => b.addEventListener('click', moreButton));
}

function attachButtons() {
    attachLikeButtons();
    attachFollowButtons();
    attachReplyButtons();
    attachMoreButtons();
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

function navigationPopupMenu() {
    function toggleNavigationMenu(event) {
        let dropdown = document.querySelector('#dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    }

    function toggleNavigationHamburger (event) {
        let main = document.querySelector('main')
        let menu = document.querySelector('#navigation-menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            main.classList.add('grayscale');
            main.classList.add('brightness-25');
        } else {
            menu.classList.add('hidden');
            main.classList.remove('grayscale');
            main.classList.remove('brightness-25');
        }
    }

    let menuButton = document.querySelector('#navigation-dropdown');
    menuButton.addEventListener('click', toggleNavigationMenu);

    let hamburgerButton = document.querySelector('#navigation-hamburger');
    hamburgerButton.addEventListener('click', toggleNavigationHamburger);
}

function setPublishPost() {
    function showImageDescription(event) {
        let image_description = document.querySelector("#image-description-container");
        let input_tag = image_description.children[1];
        if (event.target.value != '') {
            image_description.classList.remove('hidden');
            input_tag.required = true;
        } else {
            image_description.classList.add('hidden');
            input_tag.required = false;
        }
    }
    let image_upload = document.querySelector("#image-upload");
    if (image_upload != null) {
        image_upload.addEventListener('change', showImageDescription);
    }
}

function setNotificationIcon() {
    let icon = document.querySelector('#notification-icon');
    let count = document.querySelector('#notification-count');
    if (icon == null || count == null) {
        return;
    }
    fetch('/notification-count')
        .then(res => res.json())
        .then(function(j) {
            if (j.count == null || j.count == '' || j.count <= 0) {
                return;
            }
            count.innerText = '' + j.count;
            const classes = ['border', 'rounded-full', 'bg-red-500', 'border-red-500', 'text-white'];
            classes.forEach(c => icon.firstElementChild.classList.add(c));
        });
}

function attachSmallSearchIcon() {
    let ssi = document.querySelector('#small-search-icon');
    if (ssi == null) {
        return;
    }
    ssi.addEventListener('click', function(event) {
        let ssb = document.querySelector('#small-search-bar');
        if (ssb == null) {
            return;
        }
        if (ssb.classList.contains('hidden')) {
            ssb.classList.remove('hidden');
        } else {
            ssb.classList.add('hidden');
        }
    });
}

function windowOnLoad() {
    attachSmallSearchIcon();
    setNotificationIcon();
    setPostLikes();
    setProfileFollow();
    attachButtons();
    navigationPopupMenu();
    setPublishPost();
}

window.onload = windowOnLoad;
