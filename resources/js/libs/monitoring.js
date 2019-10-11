import app_constants from "../constants";
import { getJson } from "../utilities";

const { base_url } = app_constants;

const ONE_SECOND = 10000;

class Monitoring {
    constructor() {
        this.meterId = document.querySelector('.meter_id').value;
        this.url = `${base_url}meters/${this.meterId}/params`;
        this.timer;
    }

    init() {
        $("#startMonitoring").click(() => {
            this.startMonitoring();
        });
        // $("#stopMonitoring").click(this.stopMonitoring.bind(this));
        // startMonitoring();
    }

    startMonitoring() {
        this.renderParams();
        this._timer = setInterval(this.renderParams.bind(this), ONE_SECOND);
        this.setStatusPending();
    }

    async renderParams() {
        try {
            this.setStatusPending();

            this.params = await getJson(this.url);

            this.setStatusRun();

            Object.keys(params).forEach(paramName => {
                $("#" + paramName).text(params[paramName].toFixed(2));
            });
        } catch (err) {
            this.setStatusError();
            console.error(1);
            // console.error(err.responseText);
        }
    }

    setStatusRun() {
        $("#text-status").text('Запущен')
        $("#box-status").removeClass();
        $("#box-status").addClass('bg-green box-header with-border');
    }

    setStatusPending() {
        $("#text-status").text('Выполняется обновление')
    }

    setStatusError() {
        console.error("Ошибка обновления")
        $("#text-status").text('Ошибка обновления')
        $("#box-status").removeClass();
        $("#box-status").addClass('bg-red-active');
        $("#box-status").addClass('box-header with-border');
    }

    setStatusStop() {
        $("#text-status").text('остановлен')
        $("#box-status").removeClass();
        $("#box-status").addClass('box-header with-border');
    }
}

const monitoringDevice = new Monitoring();

monitoringDevice.init();