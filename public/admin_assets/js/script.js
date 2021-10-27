$.fn.DataSorting = function(options) {
    let setting = $.extend({}, {
        formId: "filter_form",
        initSort: null,
        initSearch: null,
        sortUpButton: ".fa-arrow-up",
        sortDownButton: ".fa-arrow-down",
    }, options);
    
    let form = document.querySelector("#"+setting.formId);

    $("#searchButton").on("click", evt =>  {
        let searchFormChilds = document.querySelector('.search-form').children;
        for (let index = 0; index < searchFormChilds.length; index++) {
            const element = searchFormChilds[index];
            if (element.tagName === "INPUT") {
                appendItem(element, form)
            }
        }
        this.submitForm();
    });
    $(setting.sortUpButton).on('click', evt=>{
        let currentDom = evt.currentTarget;
        let parent = currentDom.closest('th');
        let key = $(parent).data('sort');
        let input = this.createItem("input", {name:"sort["+key+"]"}, {value: "DESC"}, {hidden: true})
        this.clearUpSortingActiveClasses();
        $(currentDom).addClass('active');
        this.appendItem(input, form);
        this.submitForm();
    });

    $(setting.sortDownButton).on('click', evt=>{
        let currentDom = evt.currentTarget;
        let parent = currentDom.closest('th');
        let key = $(parent).data('sort');
        let input = this.createItem("input", {name:"sort["+key+"]"}, {value: "ASC"}, {hidden: true})
        this.clearUpSortingActiveClasses();
        $(currentDom).addClass('active');
        this.appendItem(input, form);
        this.submitForm();
    });

    
    this.clearUpSortingActiveClasses = () => {
        $(".sort").each((i,v) => {
            $(v).find('i.active').removeClass('active');
        })
    }

    this.appendItem = (item, appendDiv) => {
        //check to see if the item already exists
        let childs = appendDiv.children
        if (childs.length > 0) {
            for (let index = 0; index < childs.length; index++) {
                const element = childs[index];
                //critaria match for sorting
                if (['ASC', 'DESC'].includes(element.getAttribute('value'))) {
                    element.remove();
                }
            }
        }
        appendDiv.appendChild(item);
    }

    this.submitForm = () => {
        form.submit();
    }

    this.createItem = (tagName, ...args) => {
        let tag = document.createElement(tagName);
        if (args.length > 0) {
            args.forEach(element => {
                const [item] = Object.entries(element);
                tag.setAttribute(item[0], item[1]); 
            });
        }
        return tag;
    }

    this.init = () => {
        let parsedSort = JSON.parse(setting.initSort);
        let parsedSearch = JSON.parse(setting.initSearch);
        if (parsedSort) {
            let [key, value] = Object.entries(parsedSort)[0],
            $thDom = $(`th[data-sort='${key}']`), icon;
            $icon = value === 'DESC' ? $thDom.find('i:eq(0)') : $thDom.find('i:eq(1)');
            $icon.addClass('active') 
            let input = this.createItem("input", {name:"sort["+key+"]"}, {value: value}, {hidden: true})
            this.appendItem(input, form);
        }
        if (parsedSearch) {
            let [key, value] = Object.entries(parsedSearch)[0];
            let input = document.querySelector(`input[name='search[${key}]']`)
            input.value = value;
            this.appendItem(input, form);
        }

    }
    return this.init();
}