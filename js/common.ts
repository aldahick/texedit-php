let config: SystemJSLoader.Config = {
    "baseURL": "js/",
    "map": {
        "ace": "https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js",
        "katex": "https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js",
        "katex-autorender": "https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/contrib/auto-render.min.js",
        "marked": "https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.6/marked.min.js",
        "moment": "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"
    }
};

SystemJS.config(config);
