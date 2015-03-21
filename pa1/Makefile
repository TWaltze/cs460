
SRCDIR = $(PWD)/postgresql


all: 

testclock:
	mkdir -p ./output

	cp ./policy/freelist.clock.c      $(SRCDIR)/src/backend/storage/buffer/freelist.c
	cp ./policy/bufmgr.clock.c        $(SRCDIR)/src/backend/storage/buffer/bufmgr.c
	cp ./policy/buf_init.clock.c      $(SRCDIR)/src/backend/storage/buffer/buf_init.c
	cp ./policy/buf_internals.clock.h $(SRCDIR)/src/include/storage/buf_internals.h

	cd ./scripts && ./compile.sh $(SRCDIR) 
	cd ./scripts && ./test.sh clock $(PWD)/output 16 
	cd ./scripts && ./test.sh clock $(PWD)/output 32 
	cd ./scripts && ./test.sh clock $(PWD)/output 64 
	cd ./scripts && ./test.sh clock $(PWD)/output 80 
	cd ./scripts && ./test.sh clock $(PWD)/output 90
	cd ./scripts && ./test.sh clock $(PWD)/output 16 index 
	cd ./scripts && ./test.sh clock $(PWD)/output 32 index 
	cd ./scripts && ./test.sh clock $(PWD)/output 64 index 
	cd ./scripts && ./test.sh clock $(PWD)/output 80 index
	cd ./scripts && ./test.sh clock $(PWD)/output 90 index
	
	
testmru: 
	mkdir -p ./output

	cp ./policy/freelist.mru.c      $(SRCDIR)/src/backend/storage/buffer/freelist.c
	cp ./policy/bufmgr.mru.c        $(SRCDIR)/src/backend/storage/buffer/bufmgr.c
	cp ./policy/buf_init.mru.c      $(SRCDIR)/src/backend/storage/buffer/buf_init.c
	cp ./policy/buf_internals.mru.h $(SRCDIR)/src/include/storage/buf_internals.h

	cd ./scripts && ./compile.sh $(SRCDIR) 
	cd ./scripts && ./test.sh mru $(PWD)/output 16 
	cd ./scripts && ./test.sh mru $(PWD)/output 32 
	cd ./scripts && ./test.sh mru $(PWD)/output 64 
	cd ./scripts && ./test.sh mru $(PWD)/output 80 
	cd ./scripts && ./test.sh mru $(PWD)/output 90
	cd ./scripts && ./test.sh mru $(PWD)/output 16 index 
	cd ./scripts && ./test.sh mru $(PWD)/output 32 index 
	cd ./scripts && ./test.sh mru $(PWD)/output 64 index 
	cd ./scripts && ./test.sh mru $(PWD)/output 80 index
	cd ./scripts && ./test.sh mru $(PWD)/output 90 index
	

testlru: 
	mkdir -p ./output

	cp ./policy/freelist.lru.c      $(SRCDIR)/src/backend/storage/buffer/freelist.c
	cp ./policy/bufmgr.lru.c        $(SRCDIR)/src/backend/storage/buffer/bufmgr.c
	cp ./policy/buf_init.lru.c      $(SRCDIR)/src/backend/storage/buffer/buf_init.c
	cp ./policy/buf_internals.lru.h $(SRCDIR)/src/include/storage/buf_internals.h

	cd ./scripts && ./compile.sh $(SRCDIR) 
	cd ./scripts && ./test.sh lru $(PWD)/output 16 
	cd ./scripts && ./test.sh lru $(PWD)/output 32 
	cd ./scripts && ./test.sh lru $(PWD)/output 64 
	cd ./scripts && ./test.sh lru $(PWD)/output 80 
	cd ./scripts && ./test.sh lru $(PWD)/output 90
	cd ./scripts && ./test.sh lru $(PWD)/output 16 index 
	cd ./scripts && ./test.sh lru $(PWD)/output 32 index 
	cd ./scripts && ./test.sh lru $(PWD)/output 64 index 
	cd ./scripts && ./test.sh lru $(PWD)/output 80 index
	cd ./scripts && ./test.sh lru $(PWD)/output 90 index
	


setup:
	rm -rf $(SRCDIR)
	cd scripts && ./download.sh $(SRCDIR)
	cd $(SRCDIR) && ./configure --with-blocksize=1 
	cd scripts && ./compile.sh $(SRCDIR)
	cd ./scripts && sudo su postgres -c ./init.sh 

