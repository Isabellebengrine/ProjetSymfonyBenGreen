/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import noUiSlider from 'nouislider'
import 'nouislider/distribute/nouislider.css'
import Filter from './modules/Filter'

new Filter(document.querySelector('.js-filter'))

const slider = document.getElementById('price-slider');
//to use this only on pages where slider is used :
if(slider){
    const min = document.getElementById('min')
    const max = document.getElementById('max')
    const minValue = Math.floor(parseInt(slider.dataset.min,10)/10)*10
    const maxValue = Math.ceil(parseInt(slider.dataset.max,10)/10)*10
    const range = noUiSlider.create(slider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        step: 10,
        range: {
            'min': minValue,
            'max': maxValue
        }
    });

    range.on('slide', function (values, handle) {
        //console.log(values, handle);//to check how values change

        //if we move the left cursor it means the min value is changing :
        if(handle === 0){
            min.value = Math.round(values[0])
        }
        //same for right cursor and max value :
        if(handle === 1){
            max.value = Math.round(values[1])
        }
    })

    //to trigger an event when we finish moving the slider :
    //(else, no event is called as we use js slider for min and max, and so we cannot use eventlistener for ajax)
    range.on('end', function (values, handle){
        if (handle===0) {
            min.dispatchEvent(new Event('change'))
        } else {
            max.dispatchEvent(new Event('change'))
        }
    })

}



