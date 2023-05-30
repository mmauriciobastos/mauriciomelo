"use strict";
let container = document.querySelector('.instadisplay');
let eventContainer = document.querySelector('.event_container');

//Add CSS
const css = `<link type="text/css" rel="stylesheet" href="instagram_api/instagram_api.css"  />`;

document.head.insertAdjacentHTML("beforeend", css)

//Device window size
let width = window.innerWidth;
let deviceSize = "25%";
if (width <= 1024) {
    deviceSize = "50%";
}

let token = 'IGQVJYdjlzN21DeWlGeDVOaElOLXVwUjVwNU5veUx3NVdsTXRmaGFac0tFUTJQNDdBcVdkRFFWVHJVZAFVRazJWN2F3M1RLWk1Hc00yQ2dla3VuTkN0ak8tSms4QjE2c25iaURmSmNSSEhDbzdCODM3NwZDZD';
let testToken = 'IGQVJWeWtIWlgxVmhCVHlrVE5VdVBmcGY2MTNQTHV1a1JxdnVvUUw5RDRJNVAyVWFUa3NGMlN6ZAkhmbm5HSFlzVHBRM21pdkt3RmJrcXYzYU9iNVdidDh1ZAjZAuWkJwQ3VKc2NuRUZAhSHBFTzJ3SnlWLQZDZD';
let url = 'https://graph.instagram.com/me/media?fields=id,caption,media_type,thumbnail_url,media_url,permalink,timestamp,username&limit=8&access_token=' + testToken;

async function getData() {
    try {
        let res = await fetch(url);
        return await res.json();
    } catch (error) {
        container.innerHTML = error;
    }
}

if (eventContainer) {

    async function renderData() {
        let postData = await getData();
            let data = postData.data;
            let html = '';

            data.forEach(post => {
                let mediaUrl = post.media_url;
                let mediaType = post.media_type.toLowerCase();

                if (post.media_type == 'VIDEO') {
                    mediaUrl = post.thumbnail_url;
                }

                //search hashtag

                if (post.caption.search('#event') !== -1) {
                    let htmlSegment =
                    `
                    <div class="img-intro-left">
                        <img style="float:left" src="${mediaUrl}" alt="">
                    </div>
                    <p>${post.caption}</p>
                    <div class='event_bottom'></div>
                    `
                    html += htmlSegment;
                }

                
            }
            );
            eventContainer.innerHTML = html;


    }


        renderData();
     

}

if (container) {

    async function renderData() {
        let postData = await getData();
        let data = postData.data;
        let html = '';

        let displayCounters = false;
        let likeAndCommentCounter = '';
        if (displayCounters) {
            likeAndCommentCounter =
                `<div class="eapps-instagram-feed-posts-item-counters">
                            
                            <div class="eapps-instagram-feed-posts-item-likes-count es-post-likes-count">
                                    <svg class="eapps-instagram-feed-posts-item-likes-count-icon" viewBox="0 0 24 24">
                                        <path d="M17.7,1.5c-2,0-3.3,0.5-4.9,2.1c0,0-0.4,0.4-0.7,0.7c-0.3-0.3-0.7-0.7-0.7-0.7c-1.6-1.6-3-2.1-5-2.1C2.6,1.5,0,4.6,0,8.3
                                        c0,4.2,3.4,7.1,8.6,11.5c0.9,0.8,1.9,1.6,2.9,2.5c0.1,0.1,0.3,0.2,0.5,0.2s0.3-0.1,0.5-0.2c1.1-1,2.1-1.8,3.1-2.7
                                        c4.8-4.1,8.5-7.1,8.5-11.4C24,4.6,21.4,1.5,17.7,1.5z M14.6,18.6c-0.8,0.7-1.7,1.5-2.6,2.3c-0.9-0.7-1.7-1.4-2.5-2.1
                                        c-5-4.2-8.1-6.9-8.1-10.5c0-3.1,2.1-5.5,4.9-5.5c1.5,0,2.6,0.3,3.8,1.5c1,1,1.2,1.2,1.2,1.2C11.6,5.9,11.7,6,12,6.1
                                        c0.3,0,0.5-0.2,0.7-0.4c0,0,0.2-0.2,1.2-1.3c1.3-1.3,2.1-1.5,3.8-1.5c2.8,0,4.9,2.4,4.9,5.5C22.6,11.9,19.4,14.6,14.6,18.6z"></path>
                                    </svg>
                                <div class="eapps-instagram-feed-posts-item-likes-count-label">232</div>
                            </div>                            
        
                                    
                            <div class="eapps-instagram-feed-posts-item-comments-count es-post-comments-count">
                                <svg class="eapps-instagram-feed-posts-item-comments-count-icon" viewBox="0 0 24 24">
                                    <path d="M1,11.9C1,17.9,5.8,23,12,23c1.9,0,3.7-1,5.3-1.8l5,1.3l0,0c0.1,0,0.1,0,0.2,0c0.4,0,0.6-0.3,0.6-0.6c0-0.1,0-0.1,0-0.2
                                    l-1.3-4.9c0.9-1.6,1.4-2.9,1.4-4.8C23,5.8,18,1,12,1C5.9,1,1,5.9,1,11.9z M2.4,11.9c0-5.2,4.3-9.5,9.5-9.5c5.3,0,9.6,4.2,9.6,9.5
                                    c0,1.7-0.5,3-1.3,4.4l0,0c-0.1,0.1-0.1,0.2-0.1,0.3c0,0.1,0,0.1,0,0.1l0,0l1.1,4.1l-4.1-1.1l0,0c-0.1,0-0.1,0-0.2,0
                                    c-0.1,0-0.2,0-0.3,0.1l0,0c-1.4,0.8-3.1,1.8-4.8,1.8C6.7,21.6,2.4,17.2,2.4,11.9z"></path>
                                </svg>
        
                                <div class="eapps-instagram-feed-posts-item-comments-count-label">25</div>
                            </div>
                                                        
                    </div>`;
        }

        data.forEach(post => {
            let mediaUrl = post.media_url;
            let mediaType = post.media_type.toLowerCase();

            if (post.media_type == 'VIDEO') {
                mediaUrl = post.thumbnail_url;
            }

            //search hashtag

            if (post.caption.search('#event') !== -1) {
                console.log(post.caption + ' ok');
            }

            let htmlSegment =
                `<div class="eapps-instagram-feed-posts-item-template-tile eapps-instagram-feed-posts-item es-post eapps-instagram-feed-posts-item-type-${mediaType} eapps-instagram-feed-posts-item-visible eapps-instagram-feed-posts-item-with-data eapps-instagram-feed-posts-item-image-landscape eapps-instagram-feed-posts-item-loaded" data-code="CqaQSyhtgQ5" style="width: calc(${deviceSize} - 4px); margin: 2px;">
            <a class="eapps-instagram-feed-posts-item-link" href="${post.permalink}" eapps-link="link" target="_blank" rel="noopener noreferrer nofollow">
                <div class="eapps-instagram-feed-posts-item-media es-post-media">
                    <div class="eapps-instagram-feed-posts-item-image-wrapper">
                        <img class="img-thumbnail eapps-instagram-feed-posts-item-image es-post-media-image" src="${mediaUrl}" eapps-link="image" alt="${post.caption}">
    
                        <span class="eapps-instagram-feed-posts-item-image-icon-video eapps-instagram-feed-posts-item-image-icon es-post-type">
                            <svg viewBox="0 0 24 24">
                                <path d="M23.467,5.762c-0.118-0.045-0.232-0.068-0.342-0.068c-0.246,0-0.451,0.087-0.615,0.26l-3.76,3.217v5.766l3.76,3.578c0.164,0.173,0.369,0.26,0.615,0.26c0.109,0,0.223-0.023,0.342-0.068C23.822,18.552,24,18.284,24,17.901V6.57C24,6.186,23.822,5.917,23.467,5.762z"></path>
                                <path d="M16.33,4.412c-0.77-0.769-1.696-1.154-2.78-1.154H3.934c-1.084,0-2.01,0.385-2.78,1.154C0.385,5.182,0,6.108,0,7.192v9.616c0,1.084,0.385,2.01,1.154,2.78c0.77,0.77,1.696,1.154,2.78,1.154h9.616c1.084,0,2.01-0.385,2.78-1.154c0.77-0.77,1.154-1.696,1.154-2.78v-3.076v-3.478V7.192C17.484,6.108,17.099,5.182,16.33,4.412z M8.742,17.229c-2.888,0-5.229-2.341-5.229-5.229c0-2.888,2.341-5.229,5.229-5.229S13.971,9.112,13.971,12C13.971,14.888,11.63,17.229,8.742,17.229z"></path>
                                <circle cx="8.742" cy="12" r="3.5"></circle>
                            </svg>
                        </span>

                        <span class="eapps-instagram-feed-posts-item-image-icon-carousel eapps-instagram-feed-posts-item-image-icon es-post-type">
                            <svg viewBox="0 0 45.964 45.964">
                                <path d="M32.399,40.565H11.113v1.297c0,2.24,1.838,4.051,4.076,4.051h26.733c2.239,0,4.042-1.811,4.042-4.051V15.13c0-2.237-1.803-4.068-4.042-4.068h-1.415v21.395C40.507,36.904,36.845,40.566,32.399,40.565z"></path>
                                <path d="M0,4.102l0,28.355c0,2.241,1.814,4.067,4.051,4.067h28.365c2.237,0,4.066-1.826,4.066-4.067l0-28.356c0-2.238-1.828-4.051-4.066-4.051H4.051C1.814,0.05,0,1.862,0,4.102z"></path>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="eapps-instagram-feed-posts-item-overlay" eapps-link="overlay">
                    <div class="eapps-instagram-feed-posts-item-content" eapps-link="content">
                        ${likeAndCommentCounter}                        
                        <div class="eapps-instagram-feed-posts-item-text es-post-text" eapps-link="text">${post.caption}</div>                    
                        <div class="eapps-instagram-feed-posts-item-text es-post-text eapps-instagram-feed-posts-item-text-clone" eapps-link="text">${post.caption}</div>
                    </div>
                </div>       

                <div class="eapps-instagram-feed-posts-item-red-like-container es-post-like-notification" eapps-link="redLikeContainer"></div>
            </a>
        </div>`;


            html += htmlSegment;
        });


        container.innerHTML = html;
    }

    renderData();


}