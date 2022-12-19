    
Vue.component('marti-search-engine', {
    props: ['value'],
    data: function () {
        return {
            days : [],
            dayText : Marti.Locale.get('user.profile.birthday.day'),
            years :[],
            yearText : Marti.Locale.get('user.profile.birthday.year'),
            months: [],
            monthText : Marti.Locale.get('user.profile.birthday.month'),
            seperator : '-',
            selectText : '',
            inputClass : 'form-control form-marti',
        }
    },
    methods : {
        
    },
     
    computed: {
       
    },

    mounted : function(){
        
         var maxYear    = new Date().getFullYear();
         
         this.days      = this.range(1,32);
         this.years     = this.range(1950,maxYear);
         this.months    = this.range(1,13);
     },
     
    template: '#search-bar',

})
  
Vue.component('marti-birthday-picker', {
    props: ['value','children','item_id','max'],
    data: function () {
        return {
            days : [],
            dayText : Marti.Locale.get('user.profile.birthday.day'),
            years :[],
            yearText : Marti.Locale.get('user.profile.birthday.year'),
            months: [],
            monthText : Marti.Locale.get('user.profile.birthday.month'),
            seperator : '-',
            selectText : '',
            inputClass : 'form-control form-marti',
        }
    },
    methods : {
         range : function(start, end) {
             var count = end  - start;
             return Array.apply(0, Array(count))
               .map((element, index) => (index + start) < 10 ? ('0'+ (index+start)) : (index+start));
         }, 
         
         updateDate : function() {
             
            const dayValue      = this.$refs.dayPicker.value;
            const monthValue    = this.$refs.monthPicker.value;
            const yearValue     = this.$refs.yearPicker.value;
            
            if(dayValue != '' && yearValue != '' && monthValue != ''){
                 this.$emit('input', `${yearValue}${this.seperator}${monthValue}${this.seperator}${dayValue}`);
                 
                 $("#"+this.item_id+'_message').hide();
            }
           
         }
    },
     
    computed: {
        splitDate() {
            this.value = this.value || '';
            const splitValueString = this.value.split(this.seperator);
          
            return {
                day :   splitValueString[2] || 1,
                month:  splitValueString[1] || 1,
                year:   splitValueString[0] || 1999
            }
        },
    },

    mounted : function(){
        
         var maxYear    = new Date().getFullYear();
         
         var year = this.children ? maxYear - 17 : 1940;
         
         if(typeof this.max !== 'undefined' && this.max > 0 ){
             maxYear = maxYear - this.max +1;
             year    = maxYear - 1 ;
         }
         
         this.days      = this.range(1,32);
         this.years     = this.range(year,maxYear);
         this.months    = this.range(1,13);
     },
     
  template: `
    <div class="row m-0">
        <div class="col-4 col-md-4 p-0 pr-1 position-relative">
            <select @change="updateDate()" ref="dayPicker"  :class="inputClass"  :value="splitDate.day">
                <option value="">{{dayText}}</option>
                <option v-for="day in days">{{day}}</option>
            </select>
        </div>
        <div class="col-4 col-md-4 p-0 pr-1 position-relative">
            <select @change="updateDate()" ref="monthPicker" :class="inputClass"  :value="splitDate.month">
                <option value="">{{monthText}}</option>
                <option v-for="month in months">{{month}}</option>
            </select>
        </div>
        <div class="col-4 col-md-4 p-0 position-relative">
            <select @change="updateDate()" ref="yearPicker" :class="inputClass"  :value="splitDate.year">
                <option value="">{{yearText}}</option>
                <option v-for="year in years">{{year}}</option>
            </select>
        </div>
    </div>
    `
})


    
Vue.component('marti-loader', {
    props: ['text'],
    data: function () {
        return {
            
        }
    },
    methods : {
        
    },
     
    computed: {
      
    },

    mounted : function(){
        
    },
     
  template: `
    <div class="row m-0">
        <div class="col-md-12 p-0 pr-1">
            <div class="card text-center mb-4">
                <div class="card-body">
                    <img src="/themes/web/martireisen/assets/img/loader.png" class="loader-img m-auto"/>
                    <h4 class="card-title mt-3">Hayalinizdeki Tatil Bir Tık Uzakta</h4>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>
    </div>
    `
})