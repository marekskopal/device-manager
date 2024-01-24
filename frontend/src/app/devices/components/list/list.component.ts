import {Component, OnDestroy, OnInit} from '@angular/core';
import { first } from 'rxjs/operators';

import { DeviceService } from '@app/services';
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {AddEditComponent} from "@app/devices/components/add-edit/add-edit.component";
import {Device} from "@app/models";

@Component({ templateUrl: 'list.component.html' })
export class ListComponent implements OnInit, OnDestroy {
    public devices: Device[]|null = null;

    public constructor(
        private deviceService: DeviceService,
        private modalService: NgbModal,
    ) {}

    public ngOnInit(): void {
        this.refreshDevices();

        this.deviceService.eventEmitter.subscribe(() => {
            this.refreshDevices();
        });
    }

    public ngOnDestroy(): void {
        this.deviceService.eventEmitter.unsubscribe();
    }

    public refreshDevices(): void {
        this.deviceService.getDevices()
            .pipe(first())
            .subscribe(devices => this.devices = devices);
    }

    public addDevice(): void {
        this.modalService.open(AddEditComponent, {ariaLabelledBy: 'modal-basic-title'});
    }

    public editDevice(id: number): void {
        const addEditComponent = this.modalService.open(AddEditComponent, {ariaLabelledBy: 'modal-basic-title'});
        addEditComponent.componentInstance.id = id;
    }

    public deleteDevice(id: number): void {
        this.deviceService.deleteDevice(id)
            .pipe(first())
            .subscribe(() => this.devices = this.devices !== null ? this.devices.filter(x => x.id !== id) : null);
    }
}
