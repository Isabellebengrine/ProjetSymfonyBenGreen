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

        this.pagination.addEventListener('click', e => {
            if (e.target.tagName === 'A') {
                e.preventDefault()
                //to get url and use it in loadUrl method:
                this.loadUrl(e.target.getAttribute('href'))
            }
        })

        //nb pb 31/01/21 si je mets juste 'input' pour prendre en compte aussi les valeurs min et max
        // avec range.on('end'...) voir app.js alors je perds slider et ajax donc laissé 'input[type=checkbox]'
        //jusqu'à ce que je trouve why'
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
        this.showLoader()
        const params = new URLSearchParams(url.split('?')[1] || '')
        params.set('ajax', 1)
        const response = await fetch(url.split('?')[0] + '?' + params.toString(), {
            //add this headers so that our back-end framework knows we are doing ajax request:
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })

        //to verify status :
        if(response.status >= 200 && response.status < 300){
            //here the list of products is received in data const in json format:
            const data = await response.json()
            //to inject in our content, sorting, and pagination, the json content with this key
            this.content.innerHTML = data.content
            this.sorting.innerHTML = data.sorting
            this.pagination.innerHTML = data.pagination
            params.delete('ajax')
            //to go back directly to previous page instead of previous search made on same page:
            //to go back to previous search instead, simply replace replaceState with pushState
            history.replaceState({}, '', url.split('?')[0] + '?' + params.toString())

        } else {
            //see what to do in case of error on ajax request
            console.error(response)
        }

        this.hideLoader()
    }

    showLoader(){
        this.form.classList.add('is-loading')
        const loader = this.form.querySelector('.js-loading')
        if(loader === null){
            return
        }
        loader.setAttribute('aria-hidden', 'false')
        loader.style.display = null
    }

    hideLoader() {
        this.form.classList.remove('is-loading')
        const loader = this.form.querySelector('.js-loading')
        if(loader === null){
            return
        }
        loader.setAttribute('aria-hidden', 'true')
        loader.style.display = none
    }

}