/*------------------------------------------------------------------
* Project:        Eventen - Event Conference HTML Templates
* Author:         HtmlDesignTemplates
* URL:            https://themeforest.net/user/htmldesigntemplates
* Created:        05/10/2024
-------------------------------------------------------------------
*/

/*
 TABLE OF CONTENT
  
  1.Timer Countdown
  2.Numer count-up
  3.Spinning letter animation
  4.Slick slider
  5.Popup search
  6.Lightbox Gallery
  7.Back-to-top Button 

*/
(function($) {
  "use strict";

  AOS.init();

  /*//Timer countdown start//*/

  document.addEventListener('DOMContentLoaded', function() {
    const days = document.getElementById('days');
    const hours = document.getElementById('hours');
    const minutes = document.getElementById('minutes');
    const seconds = document.getElementById('seconds');

    // Check if all elements are found
    const elementsExist = days && hours && minutes && seconds;

    // If any element is missing, log a warning and return
    if (!elementsExist) {
        console.warn('One or more countdown elements not found.');
        return;
    }

    // Get current date and time
    const currentTime = new Date();

    // Set new date 30 days from now
    const targetTime = new Date('2025-11-25T08:00:00');

    // Update countdown time
    function updateCountdown() {
        const currentTime = new Date();
        const diff = targetTime - currentTime;

        const d = Math.floor(diff / 1000 / 60 / 60 / 24);
        const h = Math.floor((diff / 1000 / 60 / 60) % 24);
        const m = Math.floor((diff / 1000 / 60) % 60);
        const s = Math.floor((diff / 1000) % 60);

        // Update elements if they exist
        if (days) days.innerHTML = d;
        if (hours) hours.innerHTML = h < 10 ? '0' + h : h;
        if (minutes) minutes.innerHTML = m < 10 ? '0' + m : m;
        if (seconds) seconds.innerHTML = s < 10 ? '0' + s : s;
    }

    // Call updateCountdown initially and set it to run every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
  });


  /*//Timer countdown end//*/


  /*//For Counterup Start//*/
  let valueDisplays = document.querySelectorAll(".num");
  let interval = 4000;

  valueDisplays.forEach((valueDisplay) => {
      let startValue = 0;
      let endValue = parseInt(valueDisplay.getAttribute("data-val"));
      let duration = Math.floor(interval / endValue);
      let counter = setInterval(function() {
          startValue += 1;
          valueDisplay.textContent = startValue;
          if (startValue == endValue) {
              clearInterval(counter);
          }
      }, duration);
  });
  /*//For Counterup end//*/


  /*//For Spinning letter animation start//*/
  const listItems = document.querySelectorAll('.spin');
  listItems.forEach((item, index) => {
      item.style.transitionDelay = `${index * 0.1}s`;
  });
  /*//For Spinning letter animation end //*/


  /*//For slick slider start//*/
  $('.testimonial-slide').slick({
      infinite: true,
      slidesToShow: 2,
      slidesToScroll: 2,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: false,
      dots: false,
      responsive: [{
          breakpoint: 600,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      }]
  });
  /*//For slick slider end//*/

  /*//For Popup search start//*/
  $('a[href="#search1"]').on('click', function(event) {
      event.preventDefault();
      $('#search1').addClass('open');
      $('#search1 > form > input[type="search"]').focus();
  });
  $('#search1, #search1 button.close').on('click keyup', function(event) {
      if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
          $(this).removeClass('open');
      }
  });

  /*//For Popup search end//*/

  // Lightbox Gallery Start
  lightGallery(document.getElementById('selector'), {
      plugins: [lgThumbnail],
      speed: 500,
      licenseKey: 'your_license_key',
      animateThumb: true,
      zoomFromOrigin: false,
      allowMediaOverlap: true,
      toggleThumb: true,
  });


  lightGallery(document.getElementById('selector1'), {
      selector: '.item',
      plugins: [lgThumbnail],
      allowMediaOverlap: true,
      toggleThumb: true,
  });
  // Lightbox Gallery end


//   /*Masory js*/
//   window.onload = () => {
//       const grid = document.querySelector('.grid');

//       const masonry = new Masonry(grid, {
//           itemSelector: '.grid-item',
//           gutter: 1,
//           percentPosition: true
//       });
//   }
//   /*Masory js end*/

  /*Back-to-top Button start*/

  $(document).on('click', '#back-to-top, .back-to-top', () => {
      $('html, body').animate({
          scrollTop: 0
      }, '500');
      return false;
  });
  $(window).on('scroll', () => {
      if ($(window).scrollTop() > 500) {
          $('#back-to-top').fadeIn(200);
      } else {
          $('#back-to-top').fadeOut(200);
      }
  });
  /*Back-to-top Button end*/

  /*Slick Slider for product single page*/

  $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
      slidesToShow: 4,
      slidesToScroll: 0,
      asNavFor: '.slider-for',
      dots: false,
      arrows: false,
      centerMode: true,
      focusOnSelect: true,
      responsive: [{
          breakpoint: 600,
          settings: {
              slidesToShow: 4,
              slidesToScroll: 1
          }
      }]
  });

  // Reusable country list
  const countryList = [
    "Afghanistan",
    "Åland Islands",
    "Albania",
    "Algeria",
    "American Samoa",
    "Andorra",
    "Angola",
    "Anguilla",
    "Antarctica",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Aruba",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bermuda",
    "Bhutan",
    "Bolivia (Plurinational State of)",
    "Bonaire, Sint Eustatius and Saba",
    "Bosnia and Herzegovina",
    "Botswana",
    "Bouvet Island",
    "Brazil",
    "British Indian Ocean Territory",
    "Brunei Darussalam",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cabo Verde",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cayman Islands",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Christmas Island",
    "Cocos (Keeling) Islands",
    "Colombia",
    "Comoros",
    "Democratic Republic of the Congo",
    "Republic of the Congo",
    "Cook Islands",
    "Costa Rica",
    "Croatia",
    "Cuba",
    "Curaçao",
    "Cyprus",
    "Czechia",
    "Côte d'Ivoire",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Eswatini",
    "Ethiopia",
    "Falkland Islands [Malvinas]",
    "Faroe Islands",
    "Fiji",
    "Finland",
    "France",
    "French Guiana",
    "French Polynesia",
    "French Southern Territories",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Gibraltar",
    "Greece",
    "Greenland",
    "Grenada",
    "Guadeloupe",
    "Guam",
    "Guatemala",
    "Guernsey",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Heard Island and McDonald Islands",
    "Holy See",
    "Honduras",
    "Hong Kong",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran (Islamic Republic of)",
    "Iraq",
    "Ireland",
    "Isle of Man",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jersey",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea (the Democratic People's Republic of)",
    "Korea (the Republic of)",
    "Kuwait",
    "Kyrgyzstan",
    "Lao People's Democratic Republic",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macao",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Martinique",
    "Mauritania",
    "Mauritius",
    "Mayotte",
    "Mexico",
    "Micronesia (Federated States of)",
    "Moldova (the Republic of)",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Montserrat",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Caledonia",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Niue",
    "Norfolk Island",
    "Northern Mariana Islands",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Palestine",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Pitcairn",
    "Poland",
    "Portugal",
    "Puerto Rico",
    "Qatar",
    "Republic of North Macedonia",
    "Romania",
    "Russian Federation",
    "Rwanda",
    "Réunion",
    "Saint Barthélemy",
    "Saint Helena, Ascension and Tristan da Cunha",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Martin (French part)",
    "Saint Pierre and Miquelon",
    "Saint Vincent and the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Sint Maarten (Dutch part)",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Georgia and the South Sandwich Islands",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Svalbard and Jan Mayen",
    "Sweden",
    "Switzerland",
    "Syrian Arab Republic",
    "Taiwan (Province of China)",
    "Tajikistan",
    "Tanzania, United Republic of",
    "Thailand",
    "Timor-Leste",
    "Togo",
    "Tokelau",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Turks and Caicos Islands",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom of Great Britain and Northern Ireland",
    "United States Minor Outlying Islands",
    "United States of America",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Venezuela",
    "Viet Nam",
    "Virgin Islands (British)",
    "Virgin Islands (U.S.)",
    "Wallis and Futuna",
    "Western Sahara",
    "Yemen",
    "Zambia",
    "Zimbabwe"
  ];

  function populateCountrySelect(selectElement) {
    if (!selectElement) return;
    countryList.forEach(function(country) {
      const option = document.createElement('option');
      option.value = country;
      option.textContent = country;
      selectElement.appendChild(option);
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('author-country');
    const residenceSelect = document.getElementById('author-residence');
    populateCountrySelect(countrySelect);
    populateCountrySelect(residenceSelect);
  });


  

})(jQuery);

$("#abstract").validate({
    rules:{
        presenter:{
            minlength: 2,
            maxlength: 300
        },
        presenter_biography:{
            minlength: 10,
            maxlength: 500
        },
       
        special_request:{
            minlength: 10,
            maxlength: 500
        },
        title:{
            minlength: 10,
            maxlength: 300
        },
        author:{
            minlength: 2,
            maxlength: 300
        },
        author_email:{
            email:true
        },
        affliliation:{
            minlength: 2,
            maxlength: 300
        },
        
        abstract:{
            minlength: 10,
            maxlength: 3050
        }
        
        // lateBreaker:{
        //     minlength: 10,
        //     maxlength: 900
        // }
    },

    messages: {
        presenter_biography:{
            required: "Please Enter a brief biography",
            minlength: "Biography Must Be More than 10 Characters",
            maxlength: "Biography Must not Be More than 610 Characters"
        },

        presenter:{
            required: "Please Enter the Presenters Full Name",
            minlength: "Presenters Full Name Must Be More than 10 Characters",
            maxlength: "Presenters Full Name Must not Be More than 610 Characters"
        },
        
        special_request:{
            minlength: "Special Request Must Be More than 10 Characters",
            maxlength: "Special Request Must not Be More than 500 Characters"
        },
        title:{
            required: "Please Enter The Title For Your Abstract ",
            minlength: "Abstract Title Must Be More than 10 Characters",
            maxlength: "Abstract Title Must not Be More than 300 Characters"
        },
        author:{
            required: "Please Enter The Co-author(s) Of The Abstract ",
            minlength: "Abstract's Author(s) Must Be More than 2 Characters",
            maxlength: "Abstract Author(s) Must not Be More than 300 Characters"
        },
        author_email:"Please Enter Valid Email",
        affliliation:{
            required: "Please Enter The Affliliation(s) of the Author(s) Of The Abstract ",
            minlength: "Abstract's Author(s) Affliliation(s)  Must Be More than 2 Characters",
            maxlength: "Abstract Author(s) Affliliation(s)  Must not Be More than 300 Characters"
        },
        abstract:{
            required: "Please Enter The Abstract ",
            minlength: "Abstract Must Be More than 10 Characters",
            maxlength: "Abstract Must not Be More than 3,050 Characters"
        }
        // lateBreaker:{
        //     required: "Please Enter Please MOTIVATE why Your ABSTRACT is A LATE-BREAKING ABSTRACT ",
        //     minlength: "MOTIVATE Must Be More than 10 Characters",
        //     maxlength: "MOTIVATE Must not Be More than 900 Characters"
        // }

       
      },

    submitHandler: function(form) {
        form.submit();
    }

});

let controller = (function () {
    const topics = [
        {
            id: 'topic-1',
            title: 'Breaking Barriers, Building Bridges',
            subtitle: 'Overcoming impediments to African collaboration and unity',
            description: `This theme addresses the deep-rooted institutional,
                linguistic, infrastructural, and policy barriers that fragment Africa's
                research and development landscape. Discussions will focus on how to dismantle
                colonial legacies in research systems, foster multilingual and cross-regional
                knowledge exchange, and create interoperable platforms for shared
                infrastructure, ethics, and data.`
        },
        {
            id: 'topic-2',
            title: 'From Collaboration to Impact',
            subtitle: 'Scaling African-led solutions through strategic partnerships',
            description: `While collaboration is often pursued, scaling sustainable, 
                African-owned solutions remains a challenge. This theme emphasizes 
                creating high-impact partnerships across academia, government, private 
                sector, and civil society to translate research and innovation into 
                measurable development outcomes. Focus areas include models for scaling 
                grassroots innovations, financing mechanisms, and embedding African 
                solutions in policy and continental development frameworks.`
        },
        {
            id: 'topic-3',
            title: 'Africa’s Research and Innovation Ecosystem',
            subtitle: 'The role of pan-continental networks',
            description: `This theme champions the development of robust,
                continent-wide research ecosystems that are led and owned by African 
                institutions. Key discussions will explore how to establish and sustain 
                regional research consortia, leverage digital infrastructure for knowledge 
                mobility, and build inclusive networks that empower early-career researchers, 
                especially women and underrepresented groups.`
        },
        {
            id: 'topic-4',
            title: 'Data and Decision Making',
            subtitle: 'Strengthening evidence-based policy engagements using data',
            description: `Lasting and impactful societal development are a product of
                implementation of the best interventions – those based on
                evidence that works. Africa’s developmental challenges must rely on such
                evidence if it must achieve desired developmental outputs. 
                They must be grounded in factual evidence rather than relying solely on 
                intuition or anecdotal information. There is no room for unnecessary trial 
                and error, at least not in the current dispensation.  
                This need has led to the "data to policy" movement – the process of 
                using data and evidence-based research to inform and shape public policies, 
                planning and developmental discourse. In this context, data are gathered, 
                analyzed, and interpreted to understand societal problems, identify potential 
                solutions, and evaluate the effectiveness of implemented policies. 
                This approach aims to improve the quality and impact of policies. 
                For many of those working across sectors – academia, government, and private 
                sector, “data to policy” is not an intuitive process. It needs to be learned. 
                This year’s boot camp will take a tour of the key processes of using data to 
                inform policy, particularly focusing on the “how”.`
        },
    ];

    let obj = {};

    obj.showModal = function(topicId){
        console.log(topicId);
        const topic = topics.find((topic) => {
            return topic.id === topicId;
        });

        if(!topic) return;

        const html = `
            <h4 class="text-uppercase pink">${topic.title}</h4>
            <h5 class="text-capitalize">${topic.subtitle}</h5>
            <p class="mt-5 text-justify">${topic.description}</p>
        `;

        Swal.fire({
            html: html,
            confirmButtonText: 'close',
            customClass: {
                confirmButton: 'swal-confirm-btn'
            }
        });
    }

    return obj;
})();

