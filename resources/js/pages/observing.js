import app_constants from '../constants';
import { getJson } from '../utilities';
import { createStore } from 'redux';

const { base_url } = app_constants;
const CHANGE_FILTER = 'CHANGE_FILTER';
const TOGGLE_MONITORING = 'TOGGLE_MONITORING';
const REFRESH_BUILDING_LIST = 'REFRESH_BUILDING_LIST';

const initialState = {
    'filters': ['active', 'inactive', 'broken'],
    'monitoringActivness': false,
    'buildings': []
};

const changeFilters = (newFilters) => ({
    'type': CHANGE_FILTER,
    'filters': newFilters
});

const toggleMonitoring = () => ({
    'type': TOGGLE_MONITORING,
});

const refreshBuildingList = (buildings) => ({
    'type': REFRESH_BUILDING_LIST,
    'buildings': buildings
});

const mainreducer = (state = initialState, action) => {
    switch (action.type) {
        case CHANGE_FILTER:
            return {
                ...state,
                'filters': action.filters
            }
        case TOGGLE_MONITORING:
            return {
                ...state,
                'monitoringActivness': !state.monitoringActivness
            }
        case REFRESH_BUILDING_LIST:
            return {
                ...state,
                'buildings': action.buildings
            }
        default:
            return state;
    }
}

const store = createStore(mainreducer);

const iconNames = {
    electricity: 'flash',
    water: 'tint',
    heat: 'fire'
};

function getElementFromTemplate(
    templateString,
    containerElement = { tag: 'div', className: '' }
) {
    const container = document.createElement(containerElement.tag);
    container.className = containerElement.className;

    container.innerHTML = templateString;

    return container;
}

class Meter {
    constructor(meter) {
        this.id = meter.id;
        this.name = meter.name;
        this.type = meter.typeName;
        this.building_id = meter.building_id;
        this.statusStr = 'inactive';
    }

    get statusClass() {
        return `obs-devices__item obs-devices__item--${this.statusStr}`;
    }

    get template() {
        return `
            <li class="${this.statusClass}" id=meter_id_${this.id}>
                <a class="obs-devices__item-icon" href="/meters/${this.id}">
                    <i style="color: #84DBFF;" class="fa fa-${
            iconNames[this.type]
            }"></i>
                </a>
            </li>
        `.trim();
    }
}

class Building {
    constructor(building) {
        this.id = building.id;
        this.name = building.short_name;
        this.meters = building.meters_arr.map(meter => new Meter(meter));
    }

    get template() {
        return `
            <li class="obs-building__item" id=building_id_${this.id}>
                <header class="obs-building__item-header">
                    <a class="obs-building__item-title" href=${base_url +
            'buildings/' +
            this.id}>
                        ${this.name}
                    </a>
                    <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                        <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                    </svg>
                </header>
                <div class="obs-building__item-body">
                    <ul class="obs-devices__list">
                        ${this.meters
                .filter(meter => store.getState().filters.includes(meter.statusStr))
                .map(meter => meter.template)
                .join(``)}
                    </ul>
                </div>
            </li>`.trim();
    }

    compareMeterValues(meter, newValue) {
        if (meter.value) {
            console.log(`Old value: ${meter.value}, new value: ${newValue}`);

            const diff = ((newValue - meter.value) / meter.value) * 100;

            if (diff > 0.3) {
                const alertWindow = new AlertPopUp(meter, this);
                alertWindow.init();
                alertWindow.show();
            }
        }

        meter.value = newValue;
    }
}

class BuildingList {
    constructor() {
        this.buildingListUrl = `${base_url}/building_list`;
        this.meterValuesUrl = `${base_url}/meters/values`;
    }

    loadSpinner() {
        return null;
    }

    renderBuildings(buildings = store.getState().buildings) {
        // don't render buildings with no meters
        const template = buildings
            .filter(building => building.meters.length > 0)
            .map(building => building.template)
            .join(``)
            .trim();

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
        const buildingList = buildingsData.map(
            buildingData => new Building(buildingData)
        );

        store.dispatch(refreshBuildingList(buildingList));

        await this.showActiveness();
    }

    async showActiveness() {
        this.meterValues = await getJson(this.meterValuesUrl);

        this.inserValues();
    }

    inserValues() {
        const buildingsWithFilteredMeters = store.getState()
            .buildings.map(building => {
                building.meters = building.meters.map(meter => {
                    const valueItem = this.meterValues.find(
                        valueItem => valueItem.meter_id == meter.id
                    );

                    if (valueItem) {
                        building.compareMeterValues(meter, valueItem);

                        meter.statusStr = valueItem.meter_value
                            ? 'active'
                            : 'broken';
                    }

                    return meter;
                });

                return building;
            });

        store.dispatch(refreshBuildingList(buildingsWithFilteredMeters));
    }
}

class CockPit {
    constructor() {
        this.sortPanel = document.body.querySelector('.obs-sorting');
        this.monitoringBtn = document.body.querySelector(
            '.obs-start-monitoring-btn'
        );
    }

    get btnText() {
        return store.getState().monitoringActivness ?
            'Остановить мониторинг' :
            'Начать мониторинг';
    }

    refreshMonitoringStatus() {
        this.monitoringBtn.textContent = this.btnText;
        this.monitoringBtn.classList.toggle('obs-start-monitoring-btn--active');
    }

    disabledMonitoringStatus() {
        this.monitoringBtn.textContent = this.monitoringStatuses.initial;
        this.monitoringBtn.classList.remove('obs-start-monitoring-btn--active');
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
        this.cockPit.sortPanel.addEventListener(
            'change',
            this.filterChangeHandler.bind(this)
        );
        await this.buildingList.showElement();
        this.cockPit.unDisable();
    }

    async toggleMonitoring(ev) {
        store.dispatch(toggleMonitoring);
    }

    filterChangeHandler(event) {
        const checkBox = event.target.closest('.obs-sorting__item input');

        if (!checkBox) return;

        const checkedInputsSelector = '.obs-sorting__item input:checked';

        const filters = Array.from(
            document.querySelectorAll(checkedInputsSelector)
        ).map(element => element.dataset.filtertype);

        store.dispatch(changeFilters(filters));
    }
}

class AlertPopUp {
    constructor(meter, building) {
        this.meter = meter;
        this.building = building;
    }

    init() {
        this.appendPopUp();

        this.close_btn = document.querySelector('.obs-alert-popup__close-btn');

        this.close_btn.addEventListener(
            'click',
            this.closeBtnHandler.bind(this)
        );
    }

    appendPopUp() {
        this.domElement = getElementFromTemplate(
            this.template,
            {
                tag: 'div',
                className: 'obs-alert-popup__overlay'
            }
        );

        this.parentElement = document.querySelector('.content-wrapper');

        this.parentElement.appendChild(this.domElement);
    }

    closeBtnHandler(e) {
        this.hide();
    }

    show() {
        this.domElement.style.display = "block";
    }

    hide() {
        this.domElement.style.display = 'none';
    }

    get template() {
        return `
            <div class="obs-alert-popup__container">
                <section class="obs-alert-popup">
                    <div class="obs-alert-popup__upper-part">
                        <button class="obs-alert-popup__close-btn">
                            ✕
                        </button>
                    </div>
                    
                    <div class="obs-alert-popup__body">
                        <strong class="obs-alert-popup__message">Внимание!</strong>
                        <p class="obs-alert-popup__text">
                            Обнаружено подозрительное потребление в приборе учета 
                            <a href="/meters/${this.meter.id}">
                                ${this.meter.name}
                            </a>, 
                            расположенном в 
                            <a href="/buildings/${this.building.id}">
                                ${this.building.name}
                            </a>.
                        </p>
                    </div>
                </section>
            </div>`.trim();
    }
}

const app = new ObservingApp();
app.init();
store.subscribe(app.buildingList.renderBuildings.bind(app.buildingList));