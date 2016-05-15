/**
 * Created by praghav on 5/8/2016.
 */
import {Component} from '@angular/core';
import {CORE_DIRECTIVES, FORM_DIRECTIVES} from '@angular/common';
import {CAROUSEL_DIRECTIVES} from 'ng2-bootstrap/ng2-bootstrap';

@Component({
    selector: 'in-tuition-carousel',
    styleUrls: ['app/component/carousel/carousel.css'],
    templateUrl: 'app/component/carousel/carousel.html',
    directives: [CAROUSEL_DIRECTIVES, CORE_DIRECTIVES, FORM_DIRECTIVES]

})


export class InTuitionCarousel {
    public myInterval:number = 5000;
    public noWrapSlides:boolean = false;
    public slides:Array<any> = [];

    public constructor() {
        this.slides.push({
            image: `images/carousel/banner_01.png`,
            text: `'More' 'Cats'`
        });

        this.slides.push({
            image: `images/carousel/banner_02.png`,
            text: `'Extra' 'Kittys'`
        });

        this.slides.push({
            image: `images/carousel/banner_01.png`,
            text: `'Lots of' 'Felines'`
        });

    }
}