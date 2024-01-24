import {Component, OnDestroy, OnInit} from '@angular/core';
import { first } from 'rxjs/operators';

import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {Device, Owner} from "@app/models";
import {OwnerService} from "@app/services";
import {AddEditComponent} from "@app/owners/components/add-edit/add-edit.component";

@Component({ templateUrl: 'list.component.html' })
export class ListComponent implements OnInit, OnDestroy {
    public owners: Owner[]|null = null;

    public constructor(
        private ownerService: OwnerService,
        private modalService: NgbModal,
    ) {}

    public ngOnInit(): void {
        this.refreshOwners();

        this.ownerService.eventEmitter.subscribe(() => {
            this.refreshOwners();
        });
    }

    public ngOnDestroy(): void {
        this.ownerService.eventEmitter.unsubscribe();
    }

    public refreshOwners(): void {
        this.ownerService.getOwners()
            .pipe(first())
            .subscribe((owners: Owner[]) => this.owners = owners);
    }

    public addOwner(): void {
        this.modalService.open(AddEditComponent, {ariaLabelledBy: 'modal-basic-title'});
    }

    public editOwner(id: number): void {
        const addEditComponent = this.modalService.open(AddEditComponent, {ariaLabelledBy: 'modal-basic-title'});
        addEditComponent.componentInstance.id = id;
    }

    public deleteOwner(id: number): void {
        this.ownerService.deleteOwner(id)
            .pipe(first())
            .subscribe(() => this.owners = this.owners !== null ? this.owners.filter(x => x.id !== id) : null);
    }
}
