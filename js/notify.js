$("#updateForm").submit(function(){
	Push.create("Hello world!", {
    body: "How's it hangin'?",
    timeout: 4000,
    onClick: function () {
        window.focus();
        this.close();
    },
    serviceWorker: "serviceWorker.js"
	});
});