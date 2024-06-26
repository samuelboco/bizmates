<script setup>
import axios from "axios";
import { ref } from "vue";

const weatherResp = ref();
const placeInfoResp = ref();
const query = ref();
const city = ref();
const country = ref();
const defaultPlace = ref('images/def-place-image.jpg');


const getWeather = async () => {
    try {
        let rawResp = await axios.get(`/api/weather/${city.value}/${country.value}`);
        weatherResp.value = rawResp.data.list[0];
    } catch (error) {
        console.log(error);
    }
};


const getPlaceInfo = async () => {
    try {
        let rawList = await axios.get(`/api/place-info/${query.value}/${city.value}/${country.value}`);
        placeInfoResp.value = rawList.data.results
    } catch (error) {
        console.log(error);
    }
};

const search = async () => {
    if (!query.value || !city.value || !country.value) return;
    getWeather();
    getPlaceInfo();
};

let countryList = ref([]);
async function getCountryCityList() {
    try {
        let rawList = await axios.get(`https://countriesnow.space/api/v0.1/countries`);
        countryList.value = rawList.data.data;
        city.value = null;
    } catch (error) {
        console.log(error);
    }
};
getCountryCityList();

const cityList = ref([]);
async function resupplyCity() {
    try {
        let selCountry = document.getElementById('select-country');
        let countryData = countryList.value.find(data => data.iso2 === selCountry.value);
        cityList.value = countryData.cities;
    } catch (error) {
        console.log(error);
    }
}

</script>

<style>
#top-pic {
    padding-top: 150px;
    padding-bottom: 32%
}

#travel-form {
    background: #00000080;
    padding-top: 3%;
    padding-bottom: 4%;
    top: 60px;
    left: 3%;
    color: white;
    width: 38%;
    position: absolute;
    color: white
}

#travel-form div.container.row:first-child {
    padding-left: 12%;
    padding-right: 15%;
}

#form-label-weather {
    text-align: right
}

#form-input-fields {
    padding-top: 13%;
}

#form-city-label {
    margin-top: 5%;
}

#div-search-button {
    text-align: center;
    margin-top: 11%;
}

#form-search-button {
    width: 33%
}

/* #container-places {
    
} */

.places,
.weather {
    background: #000000a1;
    color: white;
    margin-top: 3%;
    margin-bottom: 3%;
    padding: 3% 3% 3% 3%;
    width: 100%;
}

#weather-info {
    text-align: right;
}

.place-desc {
    margin-top: 10%;
    font-size: large;
    font-weight: 500;
}

.place-maps-link {
    margin-top: 8%;
    font-weight: bold;
}

#text-query,
#select-country,
#select-city {
    font-weight: bold;
}
</style>

<template>
    <div class="container-fluid" id='top-pic'
        style='background-image: url("images/top.jpg"); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%;'>
        <div id='travel-form'>
            <div class="container row">
                <div id="form-input-field-div">
                    <div>
                        <h1 style="font-style: italic;">Hi There! Welcome!</h1>
                        <h5 style="margin-top: 12%;">Where do you plan to go today?</h5>
                    </div>

                    <div class="mb-3">
                        <input v-model="query" class="form-control" id="text-query"
                            placeholder="Restaurant, Hotel, Park...">
                    </div>

                    <label for="select-country" class="form-label">Country</label>
                    <select @change="resupplyCity" v-model="country" class="form-select form-select-sm"
                        aria-label=".form-select-sm example" id="select-country">
                        <option v-for="countryData in countryList" :value="countryData.iso2">{{ countryData.country }}</option>
                    </select>

                    <label for="select-city" class="form-label" id="form-city-label" disabled>City</label>
                    <select v-model="city" class="form-select form-select-sm" aria-label=".form-select-sm example"
                        id="select-city">
                        <option v-for="city in cityList" :value="city">{{ city }}</option>
                    </select>

                    <div id="div-search-button">
                        <button @click="search" type="button" class="btn btn-primary"
                            id="form-search-button">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="container-places">
        <div v-if="weatherResp" class="container row weather">
            <div class="col-6">
                <h3>{{ city + ', ' + country }}</h3>
            </div>
            <div class="col-6" id="weather-info">
                <h3>{{ weatherResp.weather[0].description + ' ' + weatherResp.main.temp + '°C'}}</h3>
            </div>
        </div>
        <div v-for="placeData in placeInfoResp" class="container row places">
            <div class="col-6">
                <img :src="defaultPlace" class="img-thumbnail" />
            </div>
            <div class="col-6">
                <h1>{{ placeData.name }}</h1>
                <div class="place-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida sapien ac
                    ipsum hendrerit, a
                    rutrum nisi volutpat. Aliquam erat volutpat. Mauris quis justo porta, scelerisque ante sit amet,
                    consequat metus. Phasellus at sem sapien. Maecenas malesuada aliquam leo, molestie commodo nunc
                    malesuada eget. Sed at diam eget odio congue semper sit amet non justo. Nulla congue, justo id
                    auctor sagittis, lectus odio ultrices velit, eget rutrum turpis felis eget arcu. Sed mi nisi, mattis
                    eget semper sed, varius non velit. Ut egestas erat sit amet dolor interdum laoreet. Vivamus quis
                    consectetur turpis, sed maximus nisi. Sed gravida viverra urna a semper. Fusce rhoncus aliquet odio
                    in elementum.</div>
                <div class="link-light place-maps-link"><a
                        :href="'https://www.google.com/maps/search/?api=1&query=' + placeData.geocodes.main.latitude + ',' + placeData.geocodes.main.longitude" target="_">Maps</a>
                </div>
            </div>
        </div>
    </div>
</template>
