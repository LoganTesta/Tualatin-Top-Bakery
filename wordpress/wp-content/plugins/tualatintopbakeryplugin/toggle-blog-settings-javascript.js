

window.addEventListener("load", function () {
    if (document.getElementsByTagName('body')[0].className === "page-blog") {
        let blogPostsContainer = document.getElementById("blogPostsContainer");
        let blogPostsDiv = document.getElementById("blogPosts");
        let orderBlogsDiv = document.createElement('div');
        orderBlogsDiv.innerHTML = "Show/hide blogs' body text";
        orderBlogsDiv.className = "order-blogs";


        blogPostsContainer.insertBefore(orderBlogsDiv, blogPostsDiv);

        document.getElementsByClassName("order-blogs")[0].className += " show";

        document.getElementsByClassName("order-blogs")[0].addEventListener("click", function () {
            let blogContentList = document.getElementsByClassName("blog__content");
            for (let i = 0; i < blogContentList.length; i++) {
                blogContentList[i].classList.toggle("hide");
            }
        }, "false");
    }
}, "false");

