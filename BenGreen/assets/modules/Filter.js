/**
 * @property {HTMLElement} pagination
 * @property {HTMLElement} content
 * @property {HTMLElement} sorting
 * Important to convert data with Formdata in loadForm method :
 * @property {HTMLFormElement} form
 */
export default class Filter {

    /**
     *
     * @param {HTMLElement|null} element
     */
    constructor(element) {
        //if element does not exist, it is useless to continue :
        if(element === null){
            return
        }
        //if element exists :
        console.log('Je me construis')//to check this is working

        this.pagination = element.querySelector('.js-filter-pagination')
        this.content = element.querySelector('.js-filter-content')
        this.sorting = element.querySelector('.js-filter-sorting')
        this.form = element.querySelector('.js-filter-form')

        this.bindEvents()

    }

    /**
     * Ajoute les comportements aux différents éléments
     */
    bindEvents(){

        //for sorting choices : we listen to click not on link but on sorting event itself :
        this.sorting.addEventListener('click', e => {
            //to check if element where user clicked is a link :
            if (e.target.tagName === 'A') {
                e.preventDefault()
                //to get url and use it in loadUrl method:
                this.loadUrl(e.target.getAttribute('href'))
            }
        })

        // this.pagination.addEventListener('click', e => {
        //     if (e.target.tagName === 'A') {
        //         e.preventDefault()
        //         //to get url and use it in loadUrl method:
        //         this.loadUrl(e.target.getAttribute('href'))
        //     }
        // })

        //for checkbox choices only you could specify 'input[type=checkbox]':
        this.form.querySelectorAll('input[type=checkbox]').forEach(input => {
            input.addEventListener('change', this.loadForm.bind(this)) //(to make sure this refers to the right element)
        })
    }

    //to make url directly from data entered in search form :
    async loadForm(){
        //to get data from search form:
        const data = new FormData(this.form)
        //to convert this data in url:
        const url = new URL(this.form.getAttribute('action') || window.location.href) //(if no 'action', gets the current url)
        const params = new URLSearchParams()
        data.forEach((value, key) => {
            params.append(key, value)
        })
        //(if needed, do 'debugger' and check what you need with params.toString)
        return this.loadUrl(url.pathname + '?' + params.toString())
    }

    //to load url and make ajax treatment :
    async loadUrl(url){
        //to avoid problem of navigator using cache of json format _product:
        const ajaxUrl = url + '&ajax=1'

        const response = await fetch(ajaxUrl, {
            //add this headers so that our back-end framework knows we are doing ajax request:
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })

        //to verify status :
        if(response.status >= 200 && response.status < 300){
            //here the list of products is received in data const in json format:
            const data = await response.json()
            //to inject in our content and sorting the json content with this key
            this.content.innerHTML = data.content
            this.sorting.innerHTML = data.sorting
            this.pagination.innerHTML = data.pagination

            //to go back directly to previous page instead of previous search made on same page:
            //to go back to previous search instead, simply replace replaceState with pushState
            history.replaceState({}, '', url)

        } else {
            //see what to do in case of error on ajax request
            console.error(response)
        }

    }


}