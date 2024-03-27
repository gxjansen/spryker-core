import { NgModule } from '@angular/core';
import { provideIcons } from '@spryker/icon';

const svg = `
<svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14">
<path d="M1.98504 13.28C1.65713 13.28 1.37606 13.1629 1.14184 12.9287C0.907613 12.6945 0.790502 12.4134 0.790502 12.0855V2.14275H0V0.948209H3.47821V0.333374H8.25635V0.948209H11.7346V2.14275H10.9441V12.0855C10.9441 12.4017 10.827 12.6798 10.5927 12.9199C10.3585 13.16 10.0774 13.28 9.74953 13.28H1.98504ZM9.74953 2.14275H1.98504V12.0855H9.74953V2.14275ZM3.82954 10.6099H4.95381V3.60078H3.82954V10.6099ZM6.78075 10.6099H7.90502V3.60078H6.78075V10.6099ZM1.98504 2.14275V12.0855V2.14275Z" />
</svg>
`;

@NgModule({
    providers: [provideIcons([IconTrashModule])],
})
export class IconTrashModule {
    static icon = 'trash';
    static svg = svg;
}
