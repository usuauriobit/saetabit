module.exports = {
    mytheme: [
        // 'corporate'
        {
            corporate: {
              ...require("daisyui/colors/themes")["[data-theme=corporate]"],
              primary: "#1b0088",
              "primary-focus": "mediumblue",
              '.tab-active': {
                'color': 'white !important',
              },
              '.btn-primary:not(.btn-outline)': {
                'color': 'white !important',
              },
            },
        },
    ]
}
