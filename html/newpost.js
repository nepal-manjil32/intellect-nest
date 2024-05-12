function publishPost(author,email) {
    var title = document.getElementById("title").value;
    var paragraph = document.getElementById("paragraph").value;
    var image = document.getElementById("image").value;
    var category = document.querySelector("select[name='category']").value;

    const currentDate = new Date().toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });

    var post = {
        title: title,
        paragraph: paragraph,
        image: image,
        category: category,
        date: currentDate,
        author: author,
        email:email
    };

    if (!validateFormData(post)) {
        alert('Please fill out all fields.');
        return;
    }

    if (post.category === "Business") 
    {
        fetch('http://localhost:3000/Business', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(post)
        }).then(res => {
            if (res.ok) {
                showSuccessMessage();
                // alert('Post published successfully!');
                // Reset form fields
                formEl.reset();
            } else {
                alert('Failed to publish post.');
            }
        }).catch(error => console.error('Error:', error));
        let success = true;
    } 
    else if(post.category === "Politics")
    {
        fetch('http://localhost:3000/Politics', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(post)
        }).then(res => {
            if (res.ok) {
                showSuccessMessage();
                // alert('Post published successfully!');
                // Reset form fields
                formEl.reset();
            } else {
                alert('Failed to publish post.');
            }
        }).catch(error => console.error('Error:', error));
    }
    else if(post.category === "Tech")
    {
        fetch('http://localhost:3000/Tech', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(post)
        }).then(res => {
            if (res.ok) {
                showSuccessMessage(); 
                formEl.reset();
            } else {
                alert('Failed to publish post.');
            }
        }).catch(error => console.error('Error:', error));
    }
    else if(post.category === "Space")
        {
            fetch('http://localhost:3000/Space', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(post)
            }).then(res => {
                if (res.ok) {
                    showSuccessMessage(); 
                    formEl.reset();
                } else {
                    alert('Failed to publish post.');
                }
            }).catch(error => console.error('Error:', error));
        }
    else
    {
        alert('Please choose the category.');
    }

}

function validateFormData(data) {
    var title = document.getElementById("title").value;
    var paragraph = document.getElementById("paragraph").value;
    var image = document.getElementById("image").value;
    var category = document.querySelector("select[name='category']").value;

    var post = {
        title: title,
        paragraph: paragraph,
        image: image,
        category: category
    };
    return post.title && post.paragraph && post.image && post.category;
}

function showSuccessMessage() {
    var successDiv = document.querySelector("#success_alert");
    successDiv.style.display = "block";
}
