$('document').ready(function() {
    $('#start-date').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#end-date').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#start-date').change(toggleDropdownMenu);
    $('#end-date').change(toggleDropdownMenu);

    $('#destination-text').on('click', 'span', resetDestination);

    setDropdownMenu('Continent', destinations.Continent);
    $('#destination-menu-list').on('click', '.destination-selection', function(e) {
        e.preventDefault();
        var menuData = getMenuData($(this).data('destinationData'));
        destinationId = $(this).data('destinationData').destinationId;
        destinationCode = getDestinationCode($(this).data('destinationData'));
        setDestinationText($(this).find('a').text());
        if (menuData) {
            setDropdownMenu(menuData.title, menuData.list);
        }
        if(destinationCode) {
            getHotels();
        }
    });
    $('#hotels').on('click', '.hotel-panel button', function() {
        var hotelPanel = $(this).closest('.hotel-panel');
        selectHotel(hotelPanel);
    });
    $('#added-hotels').on('click', '.added-hotel span', function() {
        var hotelId = parseInt($(this).closest('p').attr('hotel-id'));
        hotelIds.splice(hotelIds.indexOf(hotelId), 1);
        $(this).closest('p').remove();
        toggleAddActivityButton();
    });
    $('#add-activity-button').click(getActivities);
});

function toggleDropdownMenu() {
    if ($('#start-date').val() && $('#end-date').val()) {
        $('#destination-menu-title').prop('disabled', false);
        return;
    }
    $('#destination-menu-title').prop('disabled', true);
}

function setDropdownMenu(title, list) {
    var listHtml = '';
    $('#destination-menu-title').html('Select ' + title + ' <span class="caret"></span>');
    $('#destination-menu-list').html('');
    list.forEach(function(item) {
        var listItem = $('<li>')
            .addClass('destination-selection')
            .data('destinationData', item)
            .append($('<a>')
                .attr({href: '#'})
                .text(item.name)
            );
        $('#destination-menu-list').append(listItem);
    });
}

function getMenuData(data) {
    // console.log(data);
    for (var key in data) {
        if (data.hasOwnProperty(key)) {
            if (key === 'CityLocation') {
                return {title: 'City', list: [{name: data.name, destinationId: data.destinationId}]};
            }
            if (Array.isArray(data[key])) {
                return {title: key, list: wrapList(data[key])};
            }
            if (data[key] instanceof Object && key !== 'State') {
                return {title: key, list: wrapList(data[key])};
            }
            if (data[key] instanceof Object && key === 'State') {
                return {title: 'City', list: wrapList(data[key].City)};
            }
        }
    }
}

function wrapList(list) {
    if (Array.isArray(list)) {
        return list;
    }
    return [list];
}

function setDestinationText(text) {
    $('#destination-text').text(text + ' ');
    $('#destination-text').append($('<span>')
        .addClass('glyphicon glyphicon-repeat')
    );
}

function getDestinationCode(data) {
    if (data.destinationCode) {
        return data.destinationCode;
    }
    return null;
}

function resetDestination() {
        destinationId = undefined;
        setDestinationText('Select a Destination');
        $('#destination-text span').remove();
        setDropdownMenu('Continent', destinations.Continent);
        $('#hotels').html('');
    }

function getHotels() {
    var url = '/search-hotels?' +
    'destination=' + destinationCode +
    '&start-date=' + $('#start-date').val() +
    '&end-date=' + $('#end-date').val();
    $.get(url, function(response) {
        hotels = response;
        displayHotels(response);
    });
}

function displayHotels(hotels) {
    $('#hotels').html('');
    if ($.isEmptyObject(hotels)) {
        $('#hotels').html('<p>There are no hotels for this destination.');
        return;
    }
    hotels.Hotel.forEach(function(hotel) {
        var hotelHtml = $('<div>')
            .addClass('hotel-panel panel panel-default pull-left')
            .data('hotelData', hotel)
            .append('<div class="panel-heading truncate">' + hotel.name + '</div>' +
            '<div class="panel-body"><div class="row"><div class="col-sm-5">' +
            '<img width="100" height:"100" src="' + hotel.thumb + '"/></div>' + 
            '<div class="col-sm-7">' + hotel.minAverPrice + ' ' + hotel.currency +
            '<br><button class="select-hotel btn btn-default">Add to Package</button>' +
            '</div></div></div></div>');
        $('#hotels').append(hotelHtml);
    });
}

function selectHotel(hotelPanel) {
    var hotelData = hotelPanel.data('hotelData');
    if (hotelIds.indexOf(hotelData.hotelId) < 0) {
        hotelIds.push(hotelData.hotelId);
        $('#added-hotels').append($('<p>')
            .attr('hotel-id', hotelData.hotelId)
            .addClass('added-hotel')
            .text(hotelData.name + ' ')
            .append($('<span>')
                .addClass('glyphicon glyphicon-remove')
                .attr('aria-hidden', 'true')
            )
        );
    }
    toggleAddActivityButton();
}

function toggleAddActivityButton() {
    if (hotelIds.length > 0) {
        $('#add-activity-button').show();
        return;
    }
    $('#add-activity-button').hide();
}

function getActivities() {
     $('#hotels').html('');
}