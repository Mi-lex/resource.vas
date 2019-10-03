// Для начала нужно получить на странице полный список зданий с устройствами в них
// Пройтись по ним массивом и зарендерить все согласно шаблону
import app_constants from "../constants";
const { base_url } = app_constants;

const iconNames = {
    'electricity': 'flash',
    'water': 'tint',
    'heat': 'fire'
}

const ONE_MINUTE = 3600;

const getJson = url => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
        }).done(resolve)
            .fail(reject);
    });
}

function getElementFromTemplate(templateString, containerElement = { tag: 'div', className: '' }) {
    const container = document.createElement(containerElement.tag);
    container.className = containerElement.className;

    container.innerHTML = templateString;

    return container;
}

class Meter {
    constructor(meter) {
        this.id = meter.id
        this.name = meter.name;
        this.type = meter.typeName;
    }

    get template() {
        return `
            <li class="obs-devices__item" id=meter_id_${this.id}>
                <a class="obs-devices__item-icon" href=${base_url + 'meters/' + this.id}>
                    <i style="color: #84DBFF;" class="fa fa-${iconNames[this.type]}"></i>
                </a>
            </li>
        `.trim();
    }
}

class Building {
    constructor(building) {
        this.id = building.id
        this.name = building.short_name;
        this.meters = building.meters_arr.map(meter => new Meter(meter));
    }

    get template() {
        return `
            <li class="obs-building__item" id=building_id_${this.id}>
                <header class="obs-building__item-header">
                    <a class="obs-building__item-title" href=${base_url + 'buildings/' + this.id}>
                        ${this.name}
                    </a>
                    <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                        <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                    </svg>
                </header>
                <div class="obs-building__item-body">
                    <ul class="obs-devices__list">
                        ${this.meters.map(meter => meter.template).join(``)}
                    </ul>
                </div>
            </li>`.trim();
    }
};

class BuildingList {
    constructor() {
        this.buildingListUrl = `${base_url}/building_list`;
        this.meterValuesUrl = `${base_url}/meters/values`;
    }

    loadSpinner() {
        return null;
    }

    renderBuildings() {
        const template = this.buildingList.map(building => building.template)
            .join(``).trim();

        const container = {
            tag: 'ul',
            className: 'obs-building__list'
        };

        this.domList = getElementFromTemplate(template, container);

        const wrapper = document.querySelector('.content-wrapper');
        wrapper.appendChild(this.domList);
    }

    async showElemenet() {
        const buildingsData = await getJson(this.buildingListUrl);

        this.buildingList = buildingsData.map(buildingData => new Building(buildingData))
            // remove buildings with no meters
            .filter(building => building.meters.length > 0);

        this.renderBuildings();
        this.showActiveness();
    }

    async showActiveness() {
        this.meterValues = await getJson(this.meterValuesUrl);

        this.insertMeterClasses();
    }

    insertMeterClasses() {
        this.meterValues.forEach(el => {
            const domMeter = document.getElementById(`meter_id_${el.meter_id}`);

            let statusStr = 'obs-devices__item--';
            statusStr += el.meter_value ? 'active' : 'broken';

            domMeter.classList.add(statusStr);
        });
    }

    get elements() {
        return this.buildingList;
    }
}

const app = new BuildingList();
app.showElemenet();


