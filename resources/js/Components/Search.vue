<template>
    <ais-instant-search :search-client="searchClient" index-name="teams">
        <div class="relative px-4 py-2 rounded-t-lg"
            :class="searchFocus ? 'shadow-xl' : ''"
            v-click-away="away">
            <ais-search-box>
                <template v-slot="{ refine }">
                    <input
                        class="ais-SearchBox-input rounded-full text-md px-4 bg-gray-100 border-none placeholder-gray-500 focus:placeholder-gray-400"
                        type="search"
                        placeholder="Search Wine Window..."
                        @focus="searchFocus = true"
                        v-model="searchQuery"
                        @input="refineSearch(refine, $event.currentTarget.value)"
                    />
                    <!--                        :value="currentRefinement"-->
                    <!--                        @input="refine($event.currentTarget.value)"-->
                </template>
            </ais-search-box>
            <ais-hits class="absolute mt-2 bg-white rounded-b-lg shadow-xl -ml-4 w-full p-4"
                v-if="searchFocus">
                <template v-slot:item="{ item }">
                    <div class="py-1">
                        <Link :href="route('wineries.show', item.slug)">
                            <div>{{ item.name }}</div>
                            <div class="text-xs">Paso Robles, CA</div>
                        </Link>
                    </div>

                </template>
            </ais-hits>
        </div>
    </ais-instant-search>
</template>


<script>
import {defineComponent} from 'vue'
import {Link} from '@inertiajs/inertia-vue3';
import algoliasearch from 'algoliasearch/lite';
import {mixin as clickaway} from "vue3-click-away";
import _ from 'lodash';

export default defineComponent({
    mixins: [clickaway],

    components: {
        Link,
    },

    data() {
        return {
            searchFocus: false,
            searchQuery: '',
            searchClient: algoliasearch(
                'YSXU5Z8F6N',
                '1f88afcb9483681a37cab9d8155ca034'
            ),
        }
    },

    methods: {
        refineSearch: _.debounce(function (refine, value) {
            this.searchQuery = value
            refine(value)
        }, 400),
        away() {
            this.searchFocus = false;
        },
    }
})
</script>
