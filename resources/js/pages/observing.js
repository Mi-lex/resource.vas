import app_constants from "../constants";
import { getJson } from "../utilities";

const { base_url } = app_constants;

const iconNames = {
    'electricity': 'flash',
    'water': 'tint',
    'heat': 'fire'
}

const ONE_MINUTE = 3600;

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
        this.statusStr = 'inactive';
    }

    get statusClass() {
        return `obs-devices__item obs-devices__item--${this.statusStr}`;
    }

    get template() {
        return `
            <li class="${this.statusClass}" id=meter_id_${this.id}>
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
        this.initialMeters = building.meters_arr.map(meter => new Meter(meter));
        this.currentMeters = this.initialMeters.slice();
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
                        ${this.currentMeters.map(meter => meter.template).join(``)}
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

    renderBuildings(buildings = this.elements) {
        // don't render buildings with no meters
        const template = buildings.filter(building => building.currentMeters.length > 0)
            .map(building => building.template)
            .join(``).trim();

        const containerTag = 'ul';
        const containerClassName = 'obs-building__list';

        const oldContainer = document.querySelector(`.${containerClassName}`);

        if (oldContainer) {
            oldContainer.parentElement.removeChild(oldContainer);
        }

        const container = {
            tag: containerTag,
            className: containerClassName
        };

        this.domList = getElementFromTemplate(template, container);

        const wrapper = document.querySelector('.content-wrapper');
        wrapper.appendChild(this.domList);
    }

    async showElement() {
        const buildingsData = await getJson(this.buildingListUrl);

        this._buildingList = buildingsData.map(buildingData => new Building(buildingData));

        this.renderBuildings();
        await this.showActiveness();
    }

    async showActiveness() {
        this.meterValues = await getJson(this.meterValuesUrl);

        this.insertMeterClasses();
    }

    insertMeterClasses() {
        const buildingsWithFilteredMeters = this.elements.map(building => {
            building.currentMeters = building.initialMeters.map(meter => {
                const valueItem = this.meterValues
                    .find(valueItem => valueItem.meter_id == meter.id);

                if (valueItem) {
                    meter.value = valueItem.meter_value;
                    meter.statusStr = valueItem.meter_value ? 'active' : 'broken';
                }

                return meter;
            })

            return building;
        });

        this.renderBuildings(buildingsWithFilteredMeters);
    }

    get elements() {
        return this._buildingList;
    }
}

class CockPit {
    constructor() {
        this.sortPanel = document.body.querySelector('.obs-sorting');
        this.monitoringBtn = document.body.querySelector('.obs-start-monitoring-btn');
    }

    disable() {
        this.sortPanel.addEventListener('click', this.disableTarget);
        this.monitoringBtn.addEventListener('click', this.disableTarget);
    }

    unDisable() {
        this.sortPanel.removeEventListener('click', this.disableTarget);
        this.monitoringBtn.removeEventListener('click', this.disableTarget);
    }

    disableTarget(ev) {
        ev.preventDefault();
        return;
    }
}

class ObservingApp {
    constructor() {
        this.cockPit = new CockPit();
        this.buildingList = new BuildingList();
    }

    async init() {
        this.cockPit.disable();
        this.cockPit.sortPanel.addEventListener('change', this.filterChangeHandler.bind(this));
        await this.buildingList.showElement();
        this.cockPit.unDisable();
    }

    filterChangeHandler(event) {
        const checkBox = event.target.closest('.obs-sorting__item input');

        if (!checkBox) return;

        const checkedInputsSelector = '.obs-sorting__item input:checked';

        const filters = Array.from(document.querySelectorAll(checkedInputsSelector))
            .map(element => element.dataset.filtertype);

        const buildingsWithFilteredMeters = this.buildingList.elements.map(building => {
            building.currentMeters = building.initialMeters.filter(meter => filters.includes(meter.statusStr))

            return building;
        });

        this.buildingList.renderBuildings(buildingsWithFilteredMeters);
    }
}

const app = new ObservingApp();
app.init();

