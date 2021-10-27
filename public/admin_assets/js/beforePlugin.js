$(document).ready(function () {
    let formId = "filter_form";
    let form = document.querySelector("#"+formId);
    let initSort = `<?=json_encode(request('sort'))?>`;
    let initSearch = `<?=json_encode(request('search'))?>`;
    init();
   
    $("#searchButton").on("click", evt =>  {
        let searchFormChilds = document.querySelector('.search-form').children;
        for (let index = 0; index < searchFormChilds.length; index++) {
            const element = searchFormChilds[index];
            if (element.tagName === "INPUT") {
                appendItem(element, form)
            }
        }
        submitForm();
    });
    $(".fa-arrow-up").on('click', evt=>{
        let currentDom = evt.currentTarget;
        let parent = currentDom.closest('th');
        let key = $(parent).data('sort');
        let input = createItem("input", {name:"sort["+key+"]"}, {value: "DESC"}, {hidden: true})
        clearUpSortingActiveClasses();
        $(currentDom).addClass('active');
        appendItem(input, form);
        submitForm();
    });

    $(".fa-arrow-down").on('click', evt=>{
        let currentDom = evt.currentTarget;
        let parent = currentDom.closest('th');
        let key = $(parent).data('sort');
        let input = createItem("input", {name:"sort["+key+"]"}, {value: "ASC"}, {hidden: true})
        clearUpSortingActiveClasses();
        $(currentDom).addClass('active');
        appendItem(input, form);
        submitForm();
    });

    function clearUpSortingActiveClasses() {
        $(".sort").each((i,v) => {
            $(v).find('i.active').removeClass('active');
        })
    }

    function appendItem(item, appendDiv) {
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

    function submitForm() {
        form.submit();
    }

    function createItem(tagName, ...args) {
        let tag = document.createElement(tagName);
        if (args.length > 0) {
            args.forEach(element => {
                const [item] = Object.entries(element);
                tag.setAttribute(item[0], item[1]); 
            });
        }
        return tag;
    }

    function init() {
        let parsedSort = JSON.parse(initSort);
        let parsedSearch = JSON.parse(initSearch);
        if (parsedSort) {
            let [key, value] = Object.entries(parsedSort)[0],
            $thDom = $(`th[data-sort='${key}']`), icon;
            $icon = value === 'DESC' ? $thDom.find('i:eq(0)') : $thDom.find('i:eq(1)');
            $icon.addClass('active') 
            let input = createItem("input", {name:"sort["+key+"]"}, {value: value}, {hidden: true})
            appendItem(input, form);
        }
        if (parsedSearch) {
            let [key, value] = Object.entries(parsedSearch)[0];
            let input = document.querySelector(`input[name='search[${key}]']`)
            input.value = value;
            appendItem(input, form);
        }

    }
});