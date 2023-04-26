import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function attachLikeButtons() {
    async function clickLike(event) {
        const postId = event.target.dataset.postId;
        fetch(`/like?post_id=${ parseInt(postId) }`)
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

function attachButtons() {
    attachLikeButtons();
    attachReplyButtons();
    attachShareButtons();

}

window.onload = function() {
    attachButtons();
}
